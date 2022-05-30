<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\CaseItem;
use App\Models\Image;
use App\Models\CaseGaleryImage;

class CaseItemController extends Controller
{

    /**
     * Create a new CaseItemController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api');
        $this->middleware('user_permission:cases');
    }

    public function getOne(int $id)
    {
        $caseItem = CaseItem::with('categorie', 'image', 'galery')->find($id);
        if ($id && $caseItem) return response()->json(['caseItem' => $caseItem], 200);
        return response()->json(['caseItem' => null], 404);
    }

    public function getAll()
    {
        return response()->json(CaseItem::with('categorie', 'image', 'galery')->paginate(15), 200);
    }

    private function saveCaseItem(Request $request, CaseItem $caseItem, array $data) : JsonResponse
    {
        try { 
            $caseItem->name = $this->formatText($request->name);
            $caseItem->localization = $this->formatText($request->localization);
            $caseItem->text = $request->text;
            $caseItem->categories_id = $request->categories_id;
            $caseItem->video = $request->video;
            $caseItem->active = $request->active;

            $image = Image::find((int)  $request->images_id);
            if($image || $request->images_id == null) $caseItem->images_id = $request->images_id;

            $data['success'] = $caseItem->save();
            $data['caseItem'] = CaseItem::with('image')->find($caseItem->id);
            return response()->json($data, 200);
        } catch (\Exception $e){
            $data['success'] = false;
            $data['errors'] = ['name' => "O campo Nome do Case dever ser único e válido."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [
            'categories_id' => 'required',
            'name' => 'required|min:1|max:255|'.Rule::unique('cases', 'name')->ignore($request->id),
            'images_id' => "int|nullable",
            'video' => "url|nullable"
        ];

        $messages = [
            "unique" => "O campo :attribute deve ser único.",
            "required" => "O campo :attribute é requerido.",
            "min" => "O campo :attribute deve conter no mínimo :min caracteres.",
            "max" => "O campo :attribute deve conter no máximo :max caracteres.",
            "int" => "O campo :attribute deve ser do tipo inteiro.",
        ];

        $params = [
            "name" => "Nome do Case",
            "images_id" => "Imagem do Case"
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'caseItem' => null,
        ];
 
        if (!$validator->fails()) {
            if(!$request->id) return $this->saveCaseItem($request, new CaseItem(), $data);

            $caseItem = CaseItem::find($request->id);
            if ($caseItem) return $this->saveCaseItem($request, $caseItem, $data);

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

        $caseItem = CaseItem::find($request->id);
        if (!$validator->fails() && $caseItem instanceof CaseItem) {
            return response()->json(['success' => $caseItem->delete()], 200);
        }

        $data['errors'] = ['id' => 'Case não encontrado.', 'success' => false];
        return response()->json($data, 404);
    }

    public function addImageToGalery(Request $request)
    {
        $validations = [
            'cases_id' => "int|required",
            'images' => "array|required"
        ];

        $messages = [
            "required" => "O campo :attribute é requerido.",
            "array" => "O campo :attribute deve ser do tipo array.",
        ];

        $params = [
            "cases_id" => "Id do do Case",
            "images" => "Array de ids de imagens"
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'galeryImage' => null,
        ];
 
        if (!$validator->fails()) {
            $data['caseItems'] = $success = [];
            foreach ($request->images as $image_id) {
                $caseGaleryImage = new CaseGaleryImage([
                    'cases_id' => $request->cases_id,
                    'images_id' => $image_id,
                ]);

                $data['caseGaleryImages'] = [];

                $caseItem = CaseItem::find((int) $request->cases_id);
                $image = Image::find((int) $image_id);
                $success[$image_id] = $caseGaleryImage->save();
        
                if ($caseItem && $image && $success[$image_id]) { 
                    $image->setTableAndItem('cases',  $request->cases_id);
                    $image->save();
                    $data['caseGaleryImages'][] = CaseGaleryImage::with('image')->find($caseGaleryImage->id);
                } else {
                    $data['errors'] = [];
                    if(!isset($data['errors']['image'])) {
                        $data['errors'] = ['image' => []];
                    }

                    if (!$caseItem && !isset($data['errors']['caseItem'])) {
                        $data['errors']['caseItem'] = "Case item não encontrado";
                    }

                    if (!$image) {
                        $data['errors']['image'][$image_id] = "Imagem não encontrada";
                    }

                    if($caseGaleryImage->id) $caseGaleryImage->delete();

                    return response()->json($data, 404);
                }
            }

            $data['success'] = !in_array(false, $success);
            return response()->json($data, 200);
        } 
        return response()->json($data, 302);
    }

    public function deleteImageFromGalery(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            ['id' => 'required'], 
            ["required" => "O campo :attribute é requerido."],
            ["id" => "Identificador da imagem da galeria (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];

        $caseGaleryImage = CaseGaleryImage::find($request->id);
        if (!$validator->fails() && $caseGaleryImage) {
            $image = Image::find((int)  $caseGaleryImage->id);
            $data['success'] = $caseGaleryImage->delete();

            if ($image && $data['success']) {
                $image->setTableAndItem(null, null);
                $image->save();
            }
            return response()->json($data, 200);
        }

        $data['errors'] = ['id' => 'Imagem não encontrada.', 'success' => false];
        return response()->json($data, 404);
    }
}
