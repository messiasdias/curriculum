<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Image;
use App\Models\Categorie;
use App\Models\CaseItem;
use App\Models\User;
use App\Models\Solution;
use App\Models\ImageTrait;

class ImageController extends Controller
{
    const UPLOADS_PATH = "public";

    const TABLES_CLASSES = [
        'categories' => Categorie::class,
        'cases' => CaseItem::class,
        'users' => User::class,
        'solutions' => Solution::class
    ];

    use ImageTrait;

    /**
     * Create a new ImageController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api')->except(['getOne']);
        $this->middleware('user_permission:images')->except(['getOne']);
    }

    public function getOne(int $id)
    {
        $image = Image::with('categorie', 'user', 'case', 'solution')->find($id);
        if ($id && $image) return response()->json(['image' => $image->append('isUsed')], 200);
        return response()->json(['image' => null], 404);
    }

    public function getAll()
    {
        $images = Image::with('categorie', 'user', 'case', 'solution')->paginate(15);
        $images->each(function ($image) {$image->append('isUsed');})->sortBy('upated_at', 1);
        return response()->json($images, 200);
    }

    private function saveImage(Request $request, Image $image, array $data) : JsonResponse
    {
        try { 
            if(!$request->item_table && $request->item_id)  {
                $data['errors'] = ['item_id' => "Deve informar a tabela do item corretamente."];
                return response()->json($data, 302);
            } elseif($request->item_table && !$request->item_id)  {
                $data['errors'] = ['item_id' => "Deve informar o id do item corretamente."];
                return response()->json($data, 302);
            } else if($request->item_table && $request->item_id)  {
                $image->setTableAndItem($request->item_table,  (int) $request->item_id);
            } else {
                $image->setTableAndItem(null,  null);
            }

            if ($request->has('image') && $request->image) {
                if($image->url) $this->removeImage($image->url); 
                $image->url = $this->formatFileName($this->moveImage($request->image), false);
            }

            if($data['success'] = $image->save()) {
                $data['image'] = Image::with('categorie', 'user', 'case', 'solution')
                            ->find($image->id)
                            ->append('isUsed');
            }
                            
            return response()->json($data, 200);
        } catch (\Exception $e){
            $data['success'] = false;
            $data['errors'] = ['image' => "Ocorreu um erro ao tentar salvar imagem."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [];
        if ($request->has('image')) $validations = ['image' => "required|image"];
        if ($request->has('id')) $validations['id'] = "required:|int";
    
        $messages = [
            "required" => "O campo :attribute é requerido.",
            "image" => "O campo :attribute  deve ser conter uma imagem.",
            "int" => "O campo :attribute deve ser conter uma inteiro.",
        ];

        $params = ["image" => "imagem", "id" => "Identificador da magem (ID)"];
   
        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'image' => null,
        ];

        if (!$validator->fails()) {
            if(!$request->id) return $this->saveImage($request, new Image(), $data);

            $image = Image::find((int) $request->id);
            if ($image) return $this->saveImage($request, $image, $data);

            $data['errors'] = ['id' => 'Imagem, não encontrada.'];
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
            ["id" => "Identificador da Imagem (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];

        $image = Image::find((int) $request->id);
        if (!$validator->fails() && $image instanceof Image) {
            if($data['success'] = $image->delete()) $this->removeImage($image->url);
            return response()->json($data, 200);
        }

        $data['errors'] = ['id' => 'Imagem não encontrada.'];
        return response()->json($data, 404);
    }
}
