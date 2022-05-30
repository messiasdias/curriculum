<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Solution;
use App\Models\Image;

class SolutionController extends Controller
{

    /**
     * Create a new SolutionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api', ['except' => ['getAll']]);
        $this->middleware('user_permission:solutions')->except(['getAll']);
    }
    
    public function getOne(int $id)
    {
        $solution = Solution::with('image')->find($id);
        if ($id && $solution) return response()->json(['solution' => $solution], 200);
        return response()->json(['solution' => null], 404);
    }

    public function getAll()
    {
        return response()->json(Solution::with('image')->paginate(15), 200);
    }

    private function saveSolution(Request $request, Solution $solution, array $data) : JsonResponse
    {
        try { 
            $solution->title = $this->formatText($request->title);
            $solution->text = $this->formatText($request->text);
            $solution->active = $request->active;

            $image = Image::find((int) $request->images_id);
            if($image || $request->images_id == null) $solution->images_id = $request->images_id;
            $data['success'] = $solution->save();
            $data['solution'] = Solution::with('image')->find($solution->id);
            return response()->json($data, 200);
        } catch (\Exception $e){
            $data['success'] = false;
            $data['errors'] = ['title' => "O campo Título da Solução dever ser único e válido."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [
            'title' => 'required|min:1|max:255'.Rule::unique('solutions', 'title')->ignore($request->id),
            'images_id' => "int|nullable"
        ];

        $messages = [
            "unique" => "O campo :attribute deve ser único.",
            "required" => "O campo :attribute é requerido.",
            "min" => "O campo :attribute deve conter no mínimo :min caracteres.",
            "max" => "O campo :attribute deve conter no máximo :max caracteres.",
            "int" => "O campo :attribute deve ser do tipo inteiro.",
        ];

        $params = [
            "title" => "Título da Solução",
            "images_id" => "Imagem do Case"
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'solution' => null,
        ];
 
        if (!$validator->fails()) {
            if(!$request->id) return $this->saveSolution($request, new Solution(), $data);

            $solution = Solution::find($request->id);
            if ($solution) return $this->saveSolution($request, $solution, $data);

            $data['errors'] = ['id' => 'Case não encontrado.', 'success' => false];
            return response()->json($data, 404);
        } 
        return response()->json($data, 302);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            ['id' => 'required'], 
            ["required" => "O campo :attribute é requerido."],
            ["id" => "Identificador do Case (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];

        $solution = Solution::find($request->id);
        if (!$validator->fails() && $solution instanceof Solution) {
            return response()->json(['success' => $solution->delete()], 200);
        }

        $data['errors'] = ['id' => 'Case não encontrado.', 'success' => false];
        return response()->json($data, 404);
    }
}
