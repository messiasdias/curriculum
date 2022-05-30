<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categorie;
use App\Models\Image;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Categorie::CATEGORIES as $categorie) {
            DB::table('categories')->insert([
                'id' => $categorie['id'],
                'name' => $categorie['name'],
                'images_id' => Image::getDefaultImage('categories', $categorie['id'])['key'],
                'active' => $categorie['active'],
            ]);
        }
    }
}
