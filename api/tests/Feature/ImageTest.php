<?php

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $images;
    protected $imagesFaker;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->images = [];

        foreach(Image::IMAGES_DEFAULT as $image) {
            $this->images[] = [
                "image" => UploadedFile::fake()->create($image['url']),
                "item_table" => $image['item_table'],
                "item_id" => $image['item_id'],
            ];
        }
    }

    /**
     * Store a categorie
     * @test
     * @return void
     */
    public function check_store_and_delete_image()
    {
        $this->withExceptionHandling();

        //Error dont logged
        $response = $this->post('/api/images', $this->images[0]);
        $response->assertStatus(403);

        $this->userLogin();

        //Error on add
        $response = $this->post('/api/images', array_merge($this->images[0], ['image' => null]), $this->getRequestHeaders());
        $response->assertStatus(302);
 
        //Sucess on add
        $response = $this->post('/api/images', $this->images[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newImageId = $response->decodeResponseJson()['image']['id'];
        $this->assertEquals(true, $response->decodeResponseJson()['success']);
  
        //Sucess on delete
        $response = $this->delete('/api/images',  ["id" => $newImageId] , $this->getRequestHeaders());
        $response->assertStatus(200);
    
        //Error on delete
        $response = $this->delete('/api/images',  ["id" => $newImageId] , $this->getRequestHeaders());
        $response->assertStatus(404);
    }
}
