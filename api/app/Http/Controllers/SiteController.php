<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\CaseItem;

class SiteController extends Controller
{
    private $isPublicPath = false;

    public function __construct()
    {
        $this->isPublicPath = env('ADD_PUBLIC_PATHS');
    }

    private function allowPublicPath()
    {
        return $this->isPublicPath;
    }

    private function getData(string $pageSlug, array $mergeData = []) : ?array
    {
        $pageData = Page::formatToFront($pageSlug);
        $pageData = array_merge(is_array($pageData) ?  $pageData : [], ['public' => $this->allowPublicPath()], $mergeData);
        if (!isset($pageData['id']) || !$pageData['active']) {
          return null;
        }
        return $pageData;
    }

    private function getPage(string $page, array $mergeData = [])
    {
        if ($pageData = $this->getData($page, $mergeData)) return view($page, $pageData);
        return redirect("/home");
    }
    
    public function index()
    {
        return $this->getPage('teaser');
    }

    public function home()
    {
        return $this->getPage('home');
    }

    public function quemSomos()
    {
        return $this->getPage('quem-somos');
    }

    public function contato()
    {
        return $this->getPage('contato');
    }

    public function cases()
    {
        return $this->getPage('cases');
    }

    public function caseItem(int $id) 
    {
        $caseitem = CaseItem::with('image', 'galery')->find($id);
        return $this->getPage('interna-cases', ['caseItem' => $caseitem, 'active' => $caseitem != null]);
    }

    public function solucoes()
    {
        return $this->getPage('solucoes');
    }

    public function customPage(string $page)
    {
        if ($pageData = $this->getData($page)) return view('custom-page', $pageData);
        return redirect("/home");
    }

    public function cms()
    {
        return view('cms.cms', ['public' => $this->allowPublicPath()]);
    }
}
