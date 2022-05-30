<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Solution extends Model
{
    use HasFactory;

    //Examples pre fixed,  dont remove
    const SOLUTIONS = [
        [
            'id' => 1,
            'title' => "Análise de energia",
            'text' => "7 Quedas, Mato Grosso do Sul",
            'images_id' => null,
            'active' => true
        ],
        [
            'id' => 2,
            'title' => "Termografia",
            'text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation llamco laboris nisi ut aliquip ex ea commodo consequat.",
            'images_id' => null,
            'active' => true
        ],
        [
            'id' => 3,
            'title' => "Proteção e aterramento",
            'text' => "Temos como missão trazer a melhor tecnologia, eficiência e economia aos nossos clientes. Onde você estiver, a hora precisar, conte conosco!",
            'images_id' => null,
            'active' => true
        ]
    ];

    protected $table = 'solutions';
    
    protected $fillable = ['title', 'text', 'images_id', 'active'];

    public function image(){
        return $this->hasOne(Image::class, 'id', 'images_id');
    }
}

