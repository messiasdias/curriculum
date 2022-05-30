<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CaseItem;
use App\Models\Image;

class CasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(CaseItem::CASES as $case) {
            DB::table('cases')->insert(array_merge($case,[
                'images_id' => Image::getDefaultImage('cases', $case['id'])['key'],
            ]));
        }
    }
}
