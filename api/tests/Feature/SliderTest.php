<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Slider;
use App\Models\Image;

class SliderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $sliders, $galery;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->sliders = array_map(function ($slide) {
            return [
                'title' => $slide['title'],
                'subtitle' => $slide['subtitle'],
                'images_id' => $slide['images_id'],
                'link_url' => $slide['link_url'],
                'link_text' => $slide['link_text'],
                'broadcast_start' => $slide['broadcast_start'],
                'broadcast_end' => $slide['broadcast_end'],
                'type' => $slide['type'],
                'active' => $slide['active']
            ];
        }, Slider::SLIDERS);
    }

    /**
     * Store a slide
     * @test
     * @return void
     */
    public function check_store_slide()
    {
        $this->withExceptionHandling();

        //Error dont logged
        $response = $this->post('/api/sliders', $this->sliders[0]);
        $response->assertStatus(403);

        $this->userLogin();

        //Error on add
        $response = $this->post('/api/sliders', array_merge($this->sliders[0], ['title' => null]), $this->getRequestHeaders());
        $response->assertStatus(302);
 
        //Sucess on add
        $response = $this->post('/api/sliders', $this->sliders[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newSliderId = $response->decodeResponseJson()['slide']['id'];
        $this->assertEquals($this->sliders[0]['title'], $response->decodeResponseJson()['slide']['title']);

        //Error on add, alread exists with some title
        $response = $this->post('/api/sliders', array_merge(["id" => 2], $this->sliders[0]), $this->getRequestHeaders());
        $response->assertStatus(302);

        //Sucess update if alread exists
        $newSlideTitle = "Novo Slide";
        $response = $this->post('/api/sliders', array_merge($this->sliders[0], ["id" => $newSliderId, "title" => $newSlideTitle]), $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newSlideTitle, $response->decodeResponseJson()['slide']['title']);
    }



    /**
     * Delete a slide
     * @test
     * @return void
     */
    public function check_delete_slide()
    {
        //Error on delete
        $response = $this->delete('/api/sliders', ["id" => 5]  , $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/sliders', $this->sliders[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newSliderId = $response->decodeResponseJson()['slide']['id'];

        //Sucess on delete
        $response = $this->delete('/api/sliders',  ["id" => $newSliderId] , $this->getRequestHeaders());
        $response->assertStatus(200);
    
        //Error on delete
        $response = $this->delete('/api/sliders',  ["id" => $newSliderId] , $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one slide
     * @test
     * @return void
     */
    public function check_get_slide_item()
    {
        //Error on get
        $response = $this->get('/api/sliders/5');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/sliders', $this->sliders[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newSliderId = $response->decodeResponseJson()['slide']['id'];
        
        //Sucess on get
        $response = $this->get("/api/sliders/{$newSliderId}",  $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newSliderId, $response->decodeResponseJson()['slide']['id']);
        $this->assertEquals($this->sliders[0]['title'], $response->decodeResponseJson()['slide']['title']);
    
        //Error on get
        $response = $this->get('/api/sliders/6', $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one slide
     * @test
     * @return void
     */
    public function check_get_slide_items()
    {
        //Error
        $response = $this->get('/api/sliders');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //get sliders
        $response = $this->get('/api/sliders', $this->getRequestHeaders());
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));

        //Sucess
        foreach ($this->sliders as $s => $slide) {
            $response = $this->post('/api/sliders', [
                'title' => $slide['title'],
                'subtitle' => $slide['subtitle'],
                'images_id' => $slide['images_id'],
                'link_url' => $slide['link_url'],
                'link_text' => $slide['link_text'],
                'broadcast_start' => $slide['broadcast_start'],
                'broadcast_end' => $slide['broadcast_end'],
                'type' => $slide['type'],
                'active' => $slide['active']
            ], $this->getRequestHeaders());
            $this->assertEquals($this->sliders[$s]['title'], $response->decodeResponseJson()['slide']['title']);
        }

        //get sliders
        $response = $this->get('/api/sliders?page=1', $this->getRequestHeaders());
        $this->assertEquals(1, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(5, count($response->decodeResponseJson()['data']));

        $response = $this->get('/api/sliders?page=2', $this->getRequestHeaders());
        $this->assertEquals(2, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));
        $this->assertEquals(5, $response->decodeResponseJson()['total']);
    }
}
