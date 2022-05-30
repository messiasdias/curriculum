<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Image;

class CaseItem extends Model
{
    use HasFactory;

    //Examples pre fixed,  dont remove
    const CASES = [
        [
            'id' => 1,
            'name' => "Ademir Gomes - 3.27 KWp - 6 Placas de 545 Watts",
            'localization' => "7 Quedas, Mato Grosso do Sul",
            'text' => "",
            'categories_id' => 3,
            'images_id' => null,
            'video' => "https://www.youtube.com/embed/JTqz_xzozl0",
            'active' => true
        ],
        [
            'id' => 2,
            'name' => "Alger de Oliveira - 2,16 KWp - 4 Placas de 540 Watts",
            'localization' => "Ampére, Paraná",
            'text' => "",
            'categories_id' => 1,
            'images_id' => null,
            'video' => "https://www.youtube.com/embed/JTqz_xzozl0",
            'active' => true
        ],
        [
            'id' => 3,
            'name' => "Valino Papini - 2,16 KWp - 4 Placas de 540 Watts",
            'localization' => "Cascavel, Paraná",
            'text' => "",
            'categories_id' => 2,
            'images_id' => null,
            'video' => "https://www.youtube.com/embed/JTqz_xzozl0",
            'active' => true
        ]
    ];

    protected $table = 'cases';
    
    protected $fillable = ['name', 'localization', 'text', 'images_id', 'video' ,'categories_id', 'active'];

    public function categorie(){
        return $this->hasOne(Categorie::class, 'id', 'categories_id');
    }

    public function image(){
        return $this->hasOne(Image::class, 'id', 'images_id');
    }

    public function galery() {
        return $this->hasMany(CaseGaleryImage::class, 'cases_id', 'id');
    }
}

