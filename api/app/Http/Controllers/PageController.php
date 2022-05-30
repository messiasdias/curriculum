<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Create a new PageController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api');
        $this->middleware('user_permission:pages');
    }

    public function getOne(int $id)
    {
        $page = Page::find($id);
        if ($id && $page) return response()->json(['page' => $page], 200);
        return response()->json(['page' => null], 404);
    }

    public function getBySlug(string $slug)
    {
        $page = Page::getBySlug($slug);
        if ($slug && $page) return response()->json(['page' => $page], 200);
        return response()->json(['page' => null], 404);
    }

    public function getAll()
    {
        return response()->json(Page::paginate(15), 200);
    }

    private function savePage(Request $request, Page $page, array $data) : JsonResponse
    {
        try { 
            $page->name = ucfirst($request->name);
            $page->slug = Page::formatSlug($request->slug);
            $page->content = trim($request->content);
            $page->breadcrumb = ucwords(trim($request->breadcrumb));
            $page->breadcase = $request->breadcase;
            $page->show_home = $request->show_home;
            $page->active = $request->active;
            $page->is_default_page = $request->is_default_page;
            $data['success'] = $page->save();
            $data['page'] = $page;
            return response()->json($data, 200);
        } catch (\Exception $e){
            $data['success'] = false;
            $data['errors'] = ['form' => "Preencha todos os campos corretamente."];
            return response()->json($data, 302);
        }
    }

    public function store(Request $request)
    {
        $validations = [
            'name' => 'required|min:1|max:255'.Rule::unique('pages', 'name')->ignore($request->id),
            'slug' => 'required|min:1|max:255'.Rule::unique('pages', 'slug')->ignore($request->id),
            'content' => "nullable|min:1",
            'breadcase' => 'bool',
            'breadcrumb' => 'nullable|min:1|max:255',
            'active' => 'bool',
            'show_home' => 'bool',
            'is_default_page' => 'bool'
        ];

        $messages = [
            "unique" => "O campo :attribute deve ser único.",
            "required" => "O campo :attribute é requerido.",
            "min" => "O campo :attribute deve conter no mínimo :min caracteres.",
            "max" => "O campo :attribute deve conter no máximo :max caracteres.",
            "bool" => "O campo :attribute deve ser do tipo Verdadeiro ou Falso."
        ];

        $params = [
            "name" => "Nome da Página",
            "content" => "Conteúdo da Página",
            "slug" => "Apelido para a Página",
            "slug" => "Breadcase"
        ];

        $validator = Validator::make($request->all(), $validations, $messages, $params);

        $data = [
            'errors' => $validator->errors(), 
            'success' => false,
            'page' => null,
        ];
 
        if (!$validator->fails()) {
            if(!$request->id) return $this->savePage($request, new Page(), $data);

            $page = Page::find($request->id);
            if ($page) return $this->savePage($request, $page, $data);

            $data['errors'] = ['id' => 'Case não encontrado.'];
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

        $page = Page::find($request->id);
        if (!$validator->fails() && $page instanceof Page) {
            $data['success'] = $page->delete();
            return response()->json($data, 200);
        }

        $data['errors'] = ['id' => 'Case não encontrado.'];
        return response()->json($data, 404);
    }
}
