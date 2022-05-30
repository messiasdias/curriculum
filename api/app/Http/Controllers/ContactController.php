<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Jobs\NewContactReceived;

class ContactController extends Controller
{
    /**
     * Create a new ContactController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api')->except(['store', 'confirmEmail']);
        $this->middleware('user_permission:inbox')->except(['store', 'confirmEmail']);
    }

    public function getOne(int $id)
    {
        $contact = Contact::find($id);
        if ($id && $contact) return response()->json(['contact' => $contact], 200);
        return response()->json(['contact' => null], 404);
    }

    public function getAll(Request $request)
    {
        $value = null;
        $contacts = Contact::orderBy('created_at', 'desc');

        if($request->filterColumn !== 'archived') {
            if ($request->filterColumn && ($request->filterValue !== null && $request->filterValue !== "null")) {
                if(in_array($request->filterColumn, ['star', 'arquived'])) $value = (bool) $request->filterValue;
                else  $value = $request->filterValue;
                $contacts->where($request->filterColumn, $value)->orderBy('created_at', 'desc');
            }
            return response()->json($contacts->paginate($request->paginate ?: 10), 200);
        }
        
        $contacts->where('archived', true);
        return response()->json($contacts->paginate($request->paginate ?: 10), 200);
    }

    private function saveContact(Request $request, Contact $contact, array $data): JsonResponse
    {
        try {
            $validations = [
                $request->email != null,
                $request->phone != null,
                $request->name != null,
                $request->message != null,
            ];

            if (!in_array(false, $validations)) {
                $contact->name = ucfirst(trim($request->name));
                $contact->email = trim($request->email);
                $contact->phone = trim(str_replace(["(", ")", "-"], "", $request->phone));
                $contact->state = $request->state;
                $contact->city = $request->city;
                $contact->subject = ucfirst(trim($request->subject));
                $contact->message = ucfirst(trim($request->message));
                $contact->status = 'new';
            }
            $data['success'] = $contact->save();

            if ($contact->wasRecentlyCreated === true) {
                NewContactReceived::dispatch($contact)->delay(
                    now()->addMinutes((int) env('QUEUE_JOB_DISPATCH_DELAY', 0))
                );
            }

            $data['contact'] = $contact;
            $response =  response()
                ->json($data, 200);

            if ($data['success']) {
                $response
                    ->withCookie(cookie('user_name', $contact->name, 527040))
                    ->withCookie(cookie('user_email', $contact->email, 527040))
                    ->withCookie(cookie('user_phone', $contact->phone, 527040));
            }
            return $response;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors'] = ['form' => "Deve preencher todos os campos do formulário de contato corretamente."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|min:4|max:255',
            'phone' => 'required|min:10|max:12',
            'state' => 'required|min:2|max:2',
            'city' => 'required|min:1|max:255',
            'subject' => 'required|min:1|max:255',
            'message' => 'required|min:1'
        ];

        if ($request->id) $validations['id'] = "required|min:1";

        $messages = [
            "email" => "O campo :attribute deve ser do tipo email.",
            "required" => "O campo :attribute é requerido.",
            "min" => "O campo :attribute deve conter no mínimo :min caracteres.",
            "max" => "O campo :attribute deve conter no máximo :max caracteres.",
        ];

        $params = [
            "name" => "Nome de Contato",
            "email" => "Email de Contato",
            "phone" => "Telefone de Contato",
            "state" => "Estado do Contato",
            "city" => "Cidade do Contato",
            "subject" => "Asssunto da Mensagem",
            "message" => "Texto da Mensagem",
            "id" => "Identificador do Contato"
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(),
            'success' => false,
            'contact' => null,
        ];

        if (!Contact::validateRequest($request, $data, $params)) return response()->json($data, 302);

        if (!$validator->fails()) {
            if ($request->id) {
                $contact = Contact::find($request->id);
                if ($contact) return $this->saveContact($request, $contact, $data);
                $data['errors'] = ['id' => 'Contato não encontrado.'];
                return response()->json($data, 404);
            }
            return $this->saveContact($request,  new Contact(), $data);
        }
        return response()->json($data, 302);
    }


    public function status(Request $request)
    {
        $validations = [
            'contacts_id' => 'required|array',
            'status' => 'required|min:3|max:8',
        ];

        $messages = [
            "required" => "O campo :attribute é requerido.",
            "array" => "O campo :attribute deve dever ser do tipo array de inteiros.",
        ];

        $params = [
            "contacts_id" => "Array de Identificadores de Contato (ID)",
            "status" => "Status da Mensagem",
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = ['success' => false, 'errors' => $validator->errors()];

        if (!$validator->fails()) {
            $success = [];
            foreach ($request->contacts_id as $id) {
                $contact = Contact::find($id);
                if ($contact) {
                    $contact->setStatus($request->status, $request->authUser->id);
                    $success[] = $contact->save();
                } else {
                    $data['errors'] = ['id' => "Contato id {$id} não encontrado."];
                    $success[] = false;
                }
            }
            $data['success'] = !in_array(false, $success);
            return response()->json($data,  $data['success'] ? 200 : 404);
        }
        return response()->json($data, 302);
    }

    public function setColumn(Request $request, string $colum)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'contacts_id' => 'required|array',
                'value' => 'required|nullable'
            ],
            [
                "required" => "O campo :attribute é requerido.", 
                "array" => "O campo :attribute deve ser um array de inteiros."
            ],
            ["contacts_id" => "Array de identificadores de Contato (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];
  
        if (!$validator->fails()) {
            $success = [];
            foreach ($request->contacts_id as $id) {
                $contact = Contact::find($id);
                if ($contact) {
                    if($colum === 'star') $contact->star = $request->value;
                    if($colum === 'archived') $contact->archived = $request->value;
                    $success[] = $contact->save();
                } else {
                    $data['errors'] = ['id' => "Contato id {$id} não encontrado."];
                    $success[] = false;
                }
            }
            $data['success'] = !in_array(false, $success);
            return response()->json($data,  $data['success'] ? 200 : 404);
        }
        return response()->json($data, 302);
    }

    public function confirmEmail(int $id)
    {
        $validator = Validator::make(
            ['contact_id' => $id],
            [
                'contact_id' => 'required|int',
            ],
            [
                "required" => "O campo :attribute é requerido.", 
                "int" => "O campo :attribute deve ser do tipo inteiro."
            ],
            ["contact_id" => "Identificadore do Contato (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];
  
        if (!$validator->fails()) {
            if (! $data['success'] = Contact::setEmailConfirmation($id)) {
                $data['errors'] = ['id' => "Contato id {$id} não encontrado."];
                $data['success'] = false;
            }
            return response()->json($data,  $data['success'] ? 200 : 404);
        }
        return response()->json($data, 302);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'contacts_id' => 'required|array',
            ],
            [
                "required" => "O campo :attribute é requerido.", 
                "array" => "O campo :attribute deve ser um array de inteiros."
            ],
            ["contacts_id" => "Array de identificadores de Contato (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];
      
        if (!$validator->fails()) {
            $success = [];
            foreach ($request->contacts_id as $id) {
                $contact = Contact::find($id);
                if ($contact instanceof Contact) {
                    $success[] = $contact->delete();
                } else {
                    $data['errors'] = ['id' => "Contato id {$id} não encontrado."];
                    $success[] = false;
                }
            }
            $data['success'] = !in_array(false, $success);
            return response()->json($data,  $data['success'] ? 200 : 404);
        }
        return response()->json($data, 302);
    }
}
