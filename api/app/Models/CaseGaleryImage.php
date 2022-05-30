<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseGaleryImage extends Model
{
    use HasFactory;

    protected $table = "case_galery_images";

    protected $fillable = ['images_id', 'cases_id'];

    public function caseItem(){
        return $this->hasOne(CaseItem::class, 'id', 'cases_id');
    }

    public function image(){
        return $this->hasOne(Image::class, 'id', 'images_id');
    }
}
