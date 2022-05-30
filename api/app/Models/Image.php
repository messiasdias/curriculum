<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory; 
    use ImageTrait;

    const UPLOADS_PATH = "public";

    //Examples pre fixed,  dont remove
    const IMAGES_DEFAULT = [
        [
            "url" => "public/img/comerciais.svg",
            "item_table" => "categories",
            "item_id" => 1
        ],
        [
            "url" => "public/img/residenciais.svg",
            "item_table" => "categories",
            "item_id" => 2
        ],
        [
            "url" => "public/img/agronegocios.svg",
            "item_table" => "categories",
            "item_id" => 3
        ],
        [
            "url" => "public/img/algeroliveira.JPG",
            "item_table" => "cases",
            "item_id" => 1
        ],
        [
            "url" => "public/img/ivalinopapini.JPG",
            "item_table" => "cases",
            "item_id" => 2
        ],
        [
            "url" => "public/img/ademirgomes1.jpg",
            "item_table" => "cases",
            "item_id" => 3
        ],
        [
            "url" => "public/img/solucoes1.jpg",
            "item_table" => "solutions",
            "item_id" => 1,
        ],
        [
            "url" => "public/img/solucoes1.jpg",
            "item_table" => "solutions",
            "item_id" => 2,
        ],
        [
            "url" => "public/img/solucoes1.jpg",
            "item_table" => "solutions",
            "item_id" => 3,
        ],
        [
            "url" => "public/img/banner1.jpg",
            "item_table" => "sliders",
            "item_id" => 1,
        ],
        [
            "url" => "public/img/banner2.jpg",
            "item_table" => "sliders",
            "item_id" => 2,
        ],
        [
            "url" => "public/img/economia.svg",
            "item_table" => "sliders",
            "item_id" => 3,
        ],
        [
            "url" => "public/img/retorno.svg",
            "item_table" => "sliders",
            "item_id" => 4,
        ],
        [
            "url" => "public/img/garantia.svg",
            "item_table" => "sliders",
            "item_id" => 5,
        ]
    ];

    protected $table = 'images';

    protected $fillable = ['url', 'item_table', 'item_id'];

    protected $with = ['categorie', 'user', 'case', 'solution'];

    protected $append = ['isUsed'];

    //To seed examples images, dont remove
    public static function getDefaultImage(string $table, int $item_id) : ?array
    {
        foreach(self::IMAGES_DEFAULT as $key => $image) {
            if ($image['item_table'] === $table && $item_id === $image['item_id']) {
                $image['key'] = ($key + 1);
                return $image;
            }
        };
        return null;
    }

    public function getIsUsedAttribute(){
        return in_array(true, [
            $this->case() != null,
            $this->user() != null,
            $this->categorie() != null,
            $this->solution() != null,
        ]);
    }

    public function categorie(){
        return $this->hasOne(Categorie::class, 'images_id');
    }

    public function case(){
        return $this->hasOne(CaseItem::class, 'images_id');
    }

    public function solution(){
        return $this->hasOne(Solution::class, 'images_id');
    }

    public function slide(){
        return $this->hasOne(Slider::class, 'images_id');
    }
    
    public function user(){
        return $this->hasOne(User::class, 'images_id');
    }

    public static function resetItems(string $item_table, int $item_id, int $except = null){
        $items = Image::where('item_table', $item_table)->where('item_id', $item_id);

        if($except) $items->where("id", "!=", $except);
        
        $items->get()->each(function($image) {
            $image->item_table = null;
            $image->item_id = null;
            $image->save();
        });
    }

    public function setTableAndItem(string $item_table = null, int $item_id = null) : self
    {
        $this->item_table = $item_table && $item_table !== 'null' && !empty($item_table) ? $item_table : null;
        $this->item_id = $item_table && $item_id !== 'null' && !empty($item_id) ? $item_id : null;

        if($this->id && ($item_table && $item_table !== 'cases')) self::resetItems($item_table, (int) $item_id, (int) $this->id);
        return $this;
    }
}
