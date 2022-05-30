<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Slider;
use App\Models\Image;

class SliderController extends Controller
{
    /**
     * Create a new SliderController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api')->except(['broadcasting']);
        $this->middleware('user_permission:slider')->except(['broadcasting']);
    }

    public function getOne(int $id)
    {
        $slide = Slider::slide($id);
        return response()->json(['slide' => $slide], $slide instanceof Slider ? 200 : 404);
    }

    public function broadcasting(string $type = null)
    {
        return response()->json(Slider::broadcasting($type)->get(), 200);
    }

    public function getAll(Request $request)
    {
        return response()->json(Slider::sliders()->paginate($request->paginate ? (int) $request->paginate : 15), 200);
    }

    private function saveSlider(Request $request, Slider $slide, array $data) : JsonResponse
    {
        try { 
            $slide->title = $request->title;
            $slide->subtitle = $request->subtitle;
            $slide->link_url = $request->link_url;
            $slide->link_text = $this->formatText($request->link_text);
            $slide->broadcast_start = $request->broadcast_start;
            $slide->broadcast_end = $request->broadcast_end;
            $slide->type = strtolower($request->type);
            $slide->active = $request->active;

            $image = Image::find((int) $request->images_id);
            if($image || $request->images_id == null) $slide->images_id = $request->images_id;

            $data['success'] = $slide->save();
            $data['slide'] =Slider::slide($slide->id);
            return response()->json($data, 200);
        } catch (\Exception $e){
            $data['success'] = false;
            $data['errors'] = ['name' => "O campo Nome do Slide dever ser único e válido."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [
            'title' => "required|string|min:4|".Rule::unique('sliders', 'title')->ignore($request->id),
            'subtitle' => "present|nullable|string|min:4",
            'images_id' => "int|nullable",
            'link_url' => "string|nullable",
            'link_text' => "string|nullable",
            'broadcast_start' => 'present|date_format:"Y-m-d H:i:s"|before:broadcast_end|nullable',
            'broadcast_end' => 'present|date_format:"Y-m-d H:i:s"|after:broadcast_start|nullable',
            'type' => "required|string|min:3|max:6",
            'active' => "boolean|nullable"
        ];

        $messages = [
            "unique" => "O campo :attribute deve ser único.",
            "required" => "O campo :attribute é requerido.",
            "boolean" => "O campo :attribute deve ser do tipo boleando.",
            "date_format" => "O campo :attribute deve ser do tipo date_format:Y-m-d H:i:s.",
            "string" => "O campo :attribute deve ser do tipo string.",
            "min" => "O campo :attribute deve conter no mínimo :min caracteres.",
            "max" => "O campo :attribute deve conter no máximo :max caracteres.",
            "int" => "O campo :attribute deve ser do tipo inteiro.",
        ];

        $params = [
            'title' => "Título do Slide",
            'subtitle' => "Subtítulo do Slide",
            'images_id' => "Id da imagem",
            'link_url' => "URL do Link do Slide",
            'link_text' => "Texto do Link do Slide",
            'broadcast_start' => "Início da veiculação",
            'broadcast_end' => "Final da veiculação",
            'type' => "Tipo de Slide",
            'active' => "Ativo"
        ];

        $validator = Validator::make(array_merge($request->all(), [
            'broadcast_start' => $this->formatDateTime($request->broadcast_start),
            'broadcast_end' => $this->formatDateTime($request->broadcast_end)
        ]), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'slide' => null,
        ];
 
        if (!$validator->fails()) {
            if(!$request->id) return $this->saveSlider($request, new Slider(), $data);

            $slide = Slider::slide($request->id);
            if ($slide) return $this->saveSlider($request, $slide, $data);

            $data['errors'] = ['id' => 'Slide não encontrado.', 'success' => false];
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
            ["id" => "Identificador do Slide (ID)",]
        );

        $data = ['success' => false, 'errors' => $validator->errors()];

        $slide = Slider::slide($request->id);
        if (!$validator->fails() && $slide instanceof Slider) {
            return response()->json(['success' => $slide->delete()], 200);
        }

        $data['errors'] = ['id' => 'Slide não encontrado.', 'success' => false];
        return response()->json($data, 404);
    }
}
