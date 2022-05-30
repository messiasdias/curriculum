<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    const PAGES = [
        [
            'id' => 1,
            'name' => 'Home',
            'slug' => "home",
            'breadcrumb' => "Anuidade detalhada",
            'breadcase' => true,
            'show_home' => false,
            'active' => true,
            'content' => null,
            'is_default_page' => true
        ],
        [
            'id' => 2,
            'name' => 'Quem Somos',
            'slug' => "quem-somos",
            'breadcrumb' => "Conheça a Speel Solar",
            'breadcase' => false,
            'show_home' => true,
            'active' => true,
            'content' => "
                <h1>What is Lorem Ipsum?</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            ",
            'is_default_page' => true
        ],
        [
            'id' => 3,
            'name' => 'Contato',
            'slug' => "contato",
            'breadcrumb' => "Fale com a Speel",
            'breadcase' => false,
            'show_home' => true,
            'active' => true,
            'content' => null,
            'is_default_page' => true
        ],
        [
            'id' => 4,
            'name' => 'Cases',
            'slug' => "cases",
            'breadcrumb' => "A Speel tem a solução ideal para você ou seu negócio",
            'breadcase' => true,
            'show_home' => true,
            'active' => true,
            'content' => null,
            'is_default_page' => true
        ],
        [
            'id' => 5,
            'name' => 'Case Itens',
            'slug' => "interna-cases",
            'breadcrumb' => "A Speel tem a solução ideal para você ou seu negócio",
            'breadcase' => true,
            'show_home' => true,
            'active' => true,
            'content' => null,
            'is_default_page' => true
        ],
        [
            'id' => 6,
            'name' => 'Soluções',
            'slug' => "solucoes",
            'breadcrumb' => "Conheça nossas soluções",
            'breadcase' => true,
            'show_home' => true,
            'active' => true,
            'content' => null,
            'is_default_page' => true
        ],
        [
            'id' => 7,
            'name' => 'Teaser',
            'slug' => 'teaser',
            'breadcrumb' => null,
            'breadcase' => false,
            'show_home' => false,
            'active' => true,
            'content' => null,
            'is_default_page' => true
        ],
        [
            'id' => 8,
            'name' => 'Página Personalizada',
            'slug' => 'pagina-personalizada',
            'breadcrumb' => 'Página Personalizada',
            'breadcase' => true,
            'show_home' => true,
            'active' => true,
            'content' => "<h1>Página Personalizada</h1><p>Counteúdo da Página Personalizada</p>",
            'is_default_page' => false
        ]
    ];

    const SLUG_REPLACE = [
        [" ", "à", "á", "é", "è", "í", "ì", "ò", "ó", "ù", "ú", "ñ", "ç", "â", "ã", "ê", "ẽ", "ô", "õ"],
        ["-", "a", "a", "e", "e", "i", "i", "o", "o", "u", "u", "n", "c","a", "a", "e", "e", "o", "o"]
    ];

    protected $fillables = [
        'name',
        'slug',
        'breadcase',
        'breadcrumb',
        'content',
        'show_home',
        'active',
    ];

    public function setNomepg(string $name) : self
    {
        $this->name = trim(ucwords($name));
        return $this;
    }

    public function setSlug(string $slug) : self
    {
        $this->slug = str_replace(' ','-', trim(strtolower($slug)));
        return $this;
    }

    public function showHome() : bool
    {
        return $this->show_home;
    }

    public function isDefaultPage() : bool
    {
        return $this->content != null;
    }

    public static function getBySlug(string $slug) : ?self
    {
        return self::where('slug', $slug)->first();
    }

    public static function formatSlug(string $slug) : string
    {
        return str_replace(self::SLUG_REPLACE[0], self::SLUG_REPLACE[1], trim(strtolower($slug)));
    }

    public static function inDefaultPages(string $slug) : bool
    {
        return in_array($slug, array_filter(array_map(function($page) {
            return $page['is_default_page'] ? $page['slug'] : null;
        }, self::PAGES)));
    }

    public static function formatToFront($slugOrId) : ?array
    {
        $page = is_string($slugOrId) ? self::getBySlug($slugOrId) : self::find($slugOrId);
        if($page && $page->active) {
            return array_merge((array) $page->toArray(), [
                'nomepg' => $page->name, 
                'home' => $page->show_home == true,
                'content' =>  $page->content,
            ]);
        }
        return null;
    }
}
