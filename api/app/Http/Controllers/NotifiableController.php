<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Notifiable;

class NotifiableController extends Controller
{
      /**
     * Create a new NotifiableController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api');
        $this->middleware('user_permission:inbox');
    }
    
    public function getOne(int $id)
    {
        $notifiable = Notifiable::find($id);
        if ($id && $notifiable) return response()->json(['notifiables' => $notifiable], 200);
        return response()->json(['notifiables' => []], 404);
    }

    public function getAll()
    {
        return response()->json(Notifiable::all(), 200);
    }

    private function saveNotifiable(Request $request, Notifiable $notifiable, array $data) : JsonResponse
    {
        try { 
            $validations = [
                $request->phone != null || $request->email != null,
                $request->name != null
            ];
  
            if(!in_array(false, $validations)) { 
                $notifiable->name = ucwords(trim($request->name));
                $notifiable->email = trim($request->email);
                $notifiable->phone = trim(str_replace(["(", ")", "-"], "", $request->phone));

                if(!$request->allow_notify_to_email && $notifiable->name)  $request->allow_notify_to_email = true;
                if(!$request->allow_notify_to_phone && $notifiable->phone)  $request->allow_notify_to_phone = true;
            }

            $data['success'] = $notifiable->save();
            $data['notifiable'] = $notifiable;
            return response()->json($data, 200);
        } catch (\Exception $e){
            $data['success'] = false;
            $data['errors'] = ['form' => "Deve preencher todos os campos do formulário de contato corretamente."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|'. Rule::unique('notifiables', 'email')->ignore($request->id),
            'phone' => 'present|nullable|min:10|max:12|'.Rule::unique('notifiables', 'phone')->ignore($request->phone),
            'allow_notify_to_email' => 'boolean',
            'allow_notify_to_phone' => 'boolean',
        ];

        if($request->id) $validations['id'] = "required|min:1";

        $messages = [
            "email" => "O campo :attribute deve ser do tipo email." ,
            "required" => "O campo :attribute é requerido.",
            "unique" => "Já existe um registro para o campo :attribute informado na base de dados.",
            "min" => "O campo :attribute deve conter no mínimo :min caracteres.",
            "max" => "O campo :attribute deve conter no máximo :max caracteres.",
        ];

        $params = [
            "name" => "Nome de Contato",
            "email" => "Email de Contato",
            "phone" => "Telefone de Contato",
            "allow_notify_to_email" => "Permite notificação para email",
            "allow_notify_to_phone" => "Permite notificação para telefone",
            "id" => "Identificador do Contato"
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'notifiable' => null,
        ];
    
        if (!$validator->fails()) {
            if($request->id) {
                $notifiable = Notifiable::find($request->id);
                if($notifiable) return $this->saveNotifiable($request, $notifiable, $data);
                $data['errors'] = ['id' => 'Contato não encontrado.'];
                return response()->json($data, 404);
            }
            return $this->saveNotifiable($request,  new Notifiable(), $data);
        } 
        return response()->json($data, 302);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            ['id' => 'required'], 
            ["required" => "O campo :attribute é requerido."],
            ["id" => "Identificador do Contato (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];

        $notifiable = Notifiable::find($request->id);
        if (!$validator->fails() && $notifiable instanceof Notifiable) {
            $data['success'] = $notifiable->delete();
            return response()->json($data, 200);
        }

        $data['errors'] = ['id' => 'Contato não encontrado.'];
        return response()->json($data, 404);
    }
}
