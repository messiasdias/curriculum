<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\CaseItem;
use App\Models\Image;

class CaseItemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $cases, $galery;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->cases = array_map(function ($case) {
            return [
                'name' => $case['name'],
                'text' => $case['text'],
                'localization' => $case['localization'],
                'categories_id' => $case['categories_id'],
                'images_id' => $case['images_id'],
                'video' => $case['video'],
                'active' => $case['active'],
            ];
        }, CaseItem::CASES);

        $this->galery = [
            1 => [1, 2, 3],
            2 => [1, 2, 3],
            3 => [1, 2, 3]
        ]; 
    }

    /**
     * Store a case
     * @test
     * @return void
     */
    public function check_store_case()
    {
        $this->withExceptionHandling();

        //Error dont logged
        $response = $this->post('/api/cases', $this->cases[0]);
        $response->assertStatus(403);

        $this->userLogin();

        //Error on add
        $response = $this->post('/api/cases', array_merge($this->cases[0], ['name' => null]), $this->getRequestHeaders());
        $response->assertStatus(302);
 
        //Sucess on add
        $response = $this->post('/api/cases', $this->cases[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newCaseItemId = $response->decodeResponseJson()['caseItem']['id'];
        $this->assertEquals($this->cases[0]['name'], $response->decodeResponseJson()['caseItem']['name']);

        //Error on add, alread exists
        $response = $this->post('/api/cases', array_merge(["id" => 2], $this->cases[0]), $this->getRequestHeaders());
        $response->assertStatus(302);

        //Sucess update if alread exists
        $newCaseName = "Novo Item";
        $response = $this->post('/api/cases', array_merge($this->cases[0], ["id" => $newCaseItemId, "name" => $newCaseName]), $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newCaseName, $response->decodeResponseJson()['caseItem']['name']);
    }



    /**
     * Delete a case
     * @test
     * @return void
     */
    public function check_delete_case()
    {
        //Error on delete
        $response = $this->delete('/api/cases', ["id" => 5]  , $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/cases', $this->cases[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newCaseItemId = $response->decodeResponseJson()['caseItem']['id'];

        //Sucess on delete
        $response = $this->delete('/api/cases',  ["id" => $newCaseItemId] , $this->getRequestHeaders());
        $response->assertStatus(200);
    
        //Error on delete
        $response = $this->delete('/api/cases',  ["id" => $newCaseItemId] , $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one case
     * @test
     * @return void
     */
    public function check_get_case_item()
    {
        //Error on get
        $response = $this->get('/api/cases/5');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/cases', $this->cases[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newCaseItemId = $response->decodeResponseJson()['caseItem']['id'];
        
        //Sucess on get
        $response = $this->get("/api/cases/{$newCaseItemId}",  $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newCaseItemId, $response->decodeResponseJson()['caseItem']['id']);
        $this->assertEquals($this->cases[0]['name'], $response->decodeResponseJson()['caseItem']['name']);
    
        //Error on get
        $response = $this->get('/api/cases/5', $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one case
     * @test
     * @return void
     */
    public function check_get_case_items()
    {
        //Error
        $response = $this->get('/api/cases');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //get cases
        $response = $this->get('/api/cases', $this->getRequestHeaders());
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));

        //Sucess
        foreach ($this->cases as $c => $cat) {
            $response = $this->post('/api/cases', [
                'name' => $cat['name'],
                'localization' => $cat['localization'],
                'images_id' => $cat['images_id'],
                'categories_id' => $cat['categories_id'],
                'active' => $cat['active'],
            ], $this->getRequestHeaders());
            $this->assertEquals(ucfirst($this->cases[$c]['name']), $response->decodeResponseJson()['caseItem']['name']);
        }

        //get cases
        $response = $this->get('/api/cases?page=1', $this->getRequestHeaders());
        $this->assertEquals(1, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(3, count($response->decodeResponseJson()['data']));

        $response = $this->get('/api/cases?page=2', $this->getRequestHeaders());
        $this->assertEquals(2, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));
        $this->assertEquals(3, $response->decodeResponseJson()['total']);
    }

    /**
     * Add and remove case galery image item
     * @test
     * @return void
     */
    public function check_add_and_remove_case_galery_image_item()
    {
        //Error no logged
        $response = $this->post('/api/cases/galery', [
            'cases_id' => 1,
            'images' => $this->galery[1]
        ]);
        $response->assertStatus(403);

        //login and add fake images and cases
        $this->userLogin();

        $images = [];
        foreach(Image::IMAGES_DEFAULT as $image) {
            $response = $this->post(
                '/api/images',
                [
                    "image" => UploadedFile::fake()->create($image['url']),
                    "item_table" => $image['item_table'],
                    "item_id" => $image['item_id'],
                ],
                $this->getRequestHeaders()
            );
            $response->assertStatus(200);
            $images[] = $response->decodeResponseJson()['image'];
        }

        foreach ($this->cases as $c => $cat) {
            $response = $this->post('/api/cases', [
                'name' => $cat['name'],
                'localization' => $cat['localization'],
                'images_id' => $cat['images_id'],
                'categories_id' => $cat['categories_id'],
                'active' => $cat['active'],
            ], $this->getRequestHeaders());
            $this->assertEquals(ucfirst($this->cases[$c]['name']), $response->decodeResponseJson()['caseItem']['name']);
        }

        //Error missing images
        $response = $this->post('/api/cases/galery', [
            'cases_id' => 1,
            /*
                'images' => $this->galery[1] //missing images or cases_id
            */
        ], $this->getRequestHeaders());
        $response->assertStatus(302);


        //Error CaseItem id 50 not found
        $response = $this->post('/api/cases/galery', [
            'cases_id' => 50, //CaseItem id 50 not found
            'images' => [1] 
        ], $this->getRequestHeaders());
        $response->assertStatus(404);

        //Error Image 50 not found
        $response = $this->post('/api/cases/galery', [
            'cases_id' => 1,
            'images' => [50] //Image id 50 not found
        ], $this->getRequestHeaders());
        $response->assertStatus(404);

        //Sucess Add
        $response = $this->post('/api/cases/galery', [
            'cases_id' => 1,
            'images' => $this->galery[1]
        ], $this->getRequestHeaders());
        $response->assertStatus(200);

        //Check if is saved
        $response = $this->get('/api/cases/1', $this->getRequestHeaders());
        $this->assertEquals(3, count($response->decodeResponseJson()['caseItem']['galery']));
        $response->assertStatus(200);

        $galery = $response->decodeResponseJson()['caseItem']['galery'];

        //Error delete no logged
        $response = $this->delete('/api/cases/galery', ['id' => 100]);
        $response->assertStatus(403);

        //Error delete item not found
        $response = $this->delete('/api/cases/galery', ['id' => 200], $this->getRequestHeaders());
        $response->assertStatus(404);

        //Sucess delete
        $response = $this->delete('/api/cases/galery', ['id' =>  $galery[0]['id']], $this->getRequestHeaders());
        $response->assertStatus(200);

        //Check if is deleted
        $response = $this->get('/api/cases/1', $this->getRequestHeaders());
        $this->assertEquals(2, count($response->decodeResponseJson()['caseItem']['galery']));
        $response->assertStatus(200);

        //Delete all test images
        foreach($images as $image) {
            $this->delete('/api/images',  ["id" => $image['id']] , $this->getRequestHeaders());
        }
    }
}
