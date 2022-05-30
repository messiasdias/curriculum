<?php

namespace Tests\Feature;

use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategorieTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $categories;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->categories = array_map(function ($categorie) {
            return [
                'name' => $categorie['name'],
                'images_id' => $categorie['images_id'],
                'active' => $categorie['active'],
            ];
        }, Categorie::CATEGORIES);
    }

    /**
     * Store a categorie
     * @test
     * @return void
     */
    public function check_store_categorie()
    {
        $this->withExceptionHandling();

        //Error dont logged
        $response = $this->post('/api/categories', $this->categories[0]);
        $response->assertStatus(403);

        $this->userLogin();

        //Error on add
        $response = $this->post('/api/categories', array_merge($this->categories[0], ['name' => null]), $this->getRequestHeaders());
        $response->assertStatus(302);
 
        //Sucess on add
        $response = $this->post('/api/categories', $this->categories[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newCategorieId = $response->decodeResponseJson()['categorie']['id'];
        $this->assertEquals($this->categories[0]['name'], $response->decodeResponseJson()['categorie']['name']);

        //Error on add, alread exists
        $response = $this->post('/api/categories', array_merge(["id" => 2], $this->categories[0]), $this->getRequestHeaders());
        $response->assertStatus(404);

        //Sucess update if alread exists
        $newCategorieName = "Nova Categoria";
        $response = $this->post('/api/categories', array_merge($this->categories[0], ["id" => $newCategorieId, "name" => $newCategorieName]), $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newCategorieName, $response->decodeResponseJson()['categorie']['name']);
    }



    /**
     * Delete a categorie
     * @test
     * @return void
     */
    public function check_delete_categorie()
    {
        //Error on delete
        $response = $this->delete('/api/categories', ["id" => 5]  , $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/categories', $this->categories[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newCategorieId = $response->decodeResponseJson()['categorie']['id'];

        //Sucess on delete
        $response = $this->delete('/api/categories',  ["id" => $newCategorieId] , $this->getRequestHeaders());
        $response->assertStatus(200);
    
        //Error on delete
        $response = $this->delete('/api/categories',  ["id" => $newCategorieId] , $this->getRequestHeaders());
        $response->assertStatus(404);
    }



    /**
     * Get one categorie
     * @test
     * @return void
     */
    public function check_get_categorie()
    {
        //Error on get
        $response = $this->get('/api/categories/5');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/categories', $this->categories[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newCategorieId = $response->decodeResponseJson()['categorie']['id'];
        
        //Sucess on get
        $response = $this->get("/api/categories/{$newCategorieId}",  $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newCategorieId, $response->decodeResponseJson()['categorie']['id']);
        $this->assertEquals($this->categories[0]['name'], $response->decodeResponseJson()['categorie']['name']);
    
        //Error on get
        $response = $this->get('/api/categories/5', $this->getRequestHeaders());
        $response->assertStatus(404);
    }


        /**
     * Get one categorie
     * @test
     * @return void
     */
    public function check_get_categories()
    {
        //Error
        $response = $this->get('/api/categories');
        $response->assertStatus(200);

        // //login
        $this->userLogin();

        //get categories
        $response = $this->get('/api/categories', $this->getRequestHeaders());
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));

        //Sucess
        foreach ($this->categories as $c => $cat) {
            $response = $this->post('/api/categories', [
                'name' => $cat['name'],
                'images_id' => $cat['images_id'],
                'active' => $cat['active'],
            ], $this->getRequestHeaders());

            $this->assertEquals($this->categories[$c]['name'], $response->decodeResponseJson()['categorie']['name']);
        }

        //get categories
        $response = $this->get('/api/categories?page=1', $this->getRequestHeaders());
        $this->assertEquals(1, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(3, count($response->decodeResponseJson()['data']));

        $response = $this->get('/api/categories?page=2', $this->getRequestHeaders());
        $this->assertEquals(2, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));
        $this->assertEquals(3, $response->decodeResponseJson()['total']);
    }
}
