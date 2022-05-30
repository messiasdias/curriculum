<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Image;

class SlidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Slider::SLIDERS as $slide) {
            DB::table('sliders')->insert(array_merge($slide,[
                'images_id' => Image::getDefaultImage('sliders', $slide['id'])['key'],
            ]));
        }
    }
}
