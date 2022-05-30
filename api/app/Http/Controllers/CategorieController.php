<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Categorie;
use App\Models\Image;
use Illuminate\Http\JsonResponse;

class CategorieController extends Controller
{
    /**
     * Create a new CategorieController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api', ['except' => ['getAll']]);
        $this->middleware('user_permission:cases')->except(['getAll']);
    }

    public function getOne(int $id)
    {
        $categorie = Categorie::with('cases', 'image')->find($id);
        if ($id && $categorie) return response()->json(['categorie' => $categorie], 200);
        return response()->json(['categorie' => null], 404);
    }

    public function getAll()
    {
        return response()->json(Categorie::with('cases', 'image')->paginate(15), 200);
    }

    private function saveCategorie(Request $request, Categorie $categorie, array $data) : JsonResponse
    {
        try {
            $categorie->name = $this->formatText($request->name);
            $categorie->active = $request->active;
            $image = Image::find((int) $request->images_id);
            if($image || $request->images_id == null) $categorie->images_id = $request->images_id;
            $data['success'] = $categorie->save();
            $data['categorie'] = Categorie::with('image')->find($categorie->id);
            return response()->json($data, 200);
        } catch (\Exception $e){
            $data['success'] = false;
            $data['errors'] = ['name' => "O campo Nome da categoria dever ser único e válido."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [
            'name' => 'required|min:1|max:255'.Rule::unique('categories', 'name')->ignore($request->id),
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
            "name" => "Nome da Categoria",
            "images_id" => "Imagem da Categoria"
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'categorie' => null,
        ];

        if (!$validator->fails()) {
            if(!$request->id) return $this->saveCategorie($request, new Categorie(), $data);

            $categorie = Categorie::find($request->id);
            if ($categorie) return $this->saveCategorie($request, $categorie, $data);

            $data['errors'] = ['id' => 'Categoria não encontrada.'];
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
            ["id" => "Identificador da Categoria (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];

        $categorie = Categorie::find($request->id);
        if (!$validator->fails() && $categorie instanceof Categorie) {
            return response()->json(['success' => $categorie->delete()], 200);
        }

        $data['errors'] = ['id' => 'Categoria não encontrada.', 'success' => false];
        return response()->json($data, 404);
    }
}
