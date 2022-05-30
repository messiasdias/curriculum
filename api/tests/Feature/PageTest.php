<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Page;

class PageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $pages;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->pages = array_map(function ($page) {
            unset($page['id']);
            return $page;
        }, Page::PAGES);
    }

    /**
     * Store a page
     * @test
     * @return void
     */
    public function check_store_page()
    {
        $this->withExceptionHandling();

        //Error dont logged
        $response = $this->post('/api/pages', $this->pages[0]);
        $response->assertStatus(403);

        $this->userLogin();

        //Error on add
        $response = $this->post('/api/pages', array_merge($this->pages[0], ['name' => null]), $this->getRequestHeaders());
        $response->assertStatus(302);
 
        //Sucess on add
        $response = $this->post('/api/pages', $this->pages[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newPageId = $response->decodeResponseJson()['page']['id'];
        $this->assertEquals($this->pages[0]['name'], $response->decodeResponseJson()['page']['name']);

        //Error on add, alread exists
        $response = $this->post('/api/pages', array_merge(["id" => 2], $this->pages[0]), $this->getRequestHeaders());
        $response->assertStatus(404);

        //Sucess update if alread exists
        $newPageName = "Nova Categoria";
        $response = $this->post('/api/pages', array_merge($this->pages[0], ["id" => $newPageId, "name" => $newPageName]), $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newPageName, $response->decodeResponseJson()['page']['name']);
    }



    /**
     * Delete a page
     * @test
     * @return void
     */
    public function check_delete_page()
    {
        //Error on delete
        $response = $this->delete('/api/pages', ["id" => 5]  , $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/pages', $this->pages[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newPageId = $response->decodeResponseJson()['page']['id'];

        //Sucess on delete
        $response = $this->delete('/api/pages',  ["id" => $newPageId] , $this->getRequestHeaders());
        $response->assertStatus(200);
    
        //Error on delete
        $response = $this->delete('/api/pages',  ["id" => $newPageId] , $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one page
     * @test
     * @return void
     */
    public function check_get_page_item()
    {
        //Error on get
        $response = $this->get('/api/pages/5');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/pages', $this->pages[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newPageId = $response->decodeResponseJson()['page']['id'];
        
        //Sucess on get
        $response = $this->get("/api/pages/{$newPageId}",  $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newPageId, $response->decodeResponseJson()['page']['id']);
        $this->assertEquals($this->pages[0]['name'], $response->decodeResponseJson()['page']['name']);
    
        //Error on get
        $response = $this->get('/api/pages/5', $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one page
     * @test
     * @return void
     */
    public function check_get_page_items()
    {
        //Error
        $response = $this->get('/api/pages');
        $response->assertStatus(403);

        // //login
        $this->userLogin();

        //get pages
        $response = $this->get('/api/pages', $this->getRequestHeaders());
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));

        //Sucess
        foreach ($this->pages as $p => $page) {
            $response = $this->post('/api/pages', $page, $this->getRequestHeaders());
            $this->assertEquals($this->pages[$p]['name'], $response->decodeResponseJson()['page']['name']);
        }

        //get pages
        $response = $this->get('/api/pages?page=1', $this->getRequestHeaders());
        $this->assertEquals(1, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(8, count($response->decodeResponseJson()['data']));

        $response = $this->get('/api/pages?page=2', $this->getRequestHeaders());
        $this->assertEquals(2, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));
        $this->assertEquals(8, $response->decodeResponseJson()['total']);
    }

     /**
     * Get one page
     * @test
     * @return void
     */
    public function check_get_page_by_slug()
    {
        $slug = 'home';

        //Error
        $response = $this->get("/api/pages/slug/{$slug}");
        $response->assertStatus(403);
 
        //login
        $this->userLogin();

        //add page with slug 'home'
        $response = $this->post('/api/pages', $this->pages[0], $this->getRequestHeaders());
        $response->assertStatus(200);

        //get page by slug 'not-found' error 404
        $response = $this->get("/api/pages/slug/not-found", $this->getRequestHeaders());
        $response->assertStatus(404);
 
         //get page by slug 'home' success 200
         $response = $this->get("/api/pages/slug/{$slug}", $this->getRequestHeaders());
         $this->assertEquals($slug, $response->decodeResponseJson()['page']['slug']);
         $response->assertStatus(200);
    }
}
