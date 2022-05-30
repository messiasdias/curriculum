<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseItem;
use App\Models\Image;

class Categorie extends Model
{
    use HasFactory;

    //Examples pre fixed, dont remove
    const CATEGORIES = [
        [
            'id' => 1,
            'name' => "Comerciais",
            'images_id' => null,
            'active' => true
        ],
        [
            'id' => 2,
            'name' => "Residenciais",
            'images_id' => null,
            'active' => true
        ],
        [
            'id' => 3,
            'name' => "Agronegócios",
            'images_id' => null,
            'active' => true
        ]
    ];

    protected $fillable = ['name', 'images_id', 'active'];

    public function cases(){
        return $this->hasMany(CaseItem::class, 'categories_id', 'id')->with('image');
    }

    public function image(){
        return $this->hasOne(Image::class, 'id', 'images_id');
    }
}
