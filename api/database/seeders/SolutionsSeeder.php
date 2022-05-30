<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Solution;
use App\Models\Image;

class SolutionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Solution::SOLUTIONS as $solution) {
            DB::table('solutions')->insert(array_merge($solution,[
                'images_id' => Image::getDefaultImage('solutions', $solution['id'])['key'],
            ]));
        }
    }
}
