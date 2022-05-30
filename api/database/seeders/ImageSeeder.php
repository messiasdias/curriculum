<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Image::IMAGES_DEFAULT as $image) {
            $imageObject = new Image($image);
            
            //convert filename to file and move to storage
            $fileUploaded = $imageObject->pathToUploadedFile($image['url']);
            $imageObject->url = $imageObject->formatFileName($imageObject->moveImage($fileUploaded), false);

            $imageObject->save();
        }
    }
}
