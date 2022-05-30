<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Solution;

class SolutionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $solutions;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->solutions = array_map(function ($solution) {
            return [
                'title' => $solution['title'],
                'text' => $solution['text'],
                'images_id' => $solution['images_id'],
                'active' => $solution['active'],
            ];
        }, Solution::SOLUTIONS);
    }

    /**
     * Store a solution
     * @test
     * @return void
     */
    public function check_store_solution()
    {
    
        //Error dont logged
        $response = $this->post('/api/solutions', $this->solutions[0]);
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Error on add
        $response = $this->post('/api/solutions', array_merge($this->solutions[0], ['title' => null]), $this->getRequestHeaders());
        $response->assertStatus(302);
 
        //Sucess on add
        $response = $this->post('/api/solutions', $this->solutions[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newSolutionId = $response->decodeResponseJson()['solution']['id'];
        $this->assertEquals($this->solutions[0]['title'], $response->decodeResponseJson()['solution']['title']);

        //Error on add, alread exists
        $response = $this->post('/api/solutions', array_merge(["id" => 2], $this->solutions[0]), $this->getRequestHeaders());
        $response->assertStatus(404);

        //Sucess update if alread exists
        $newSolutionTitle = "Nova Solução";
        $response = $this->post('/api/solutions', array_merge($this->solutions[0], ["id" => $newSolutionId, "title" => $newSolutionTitle]), $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newSolutionTitle, $response->decodeResponseJson()['solution']['title']);
    }



    /**
     * Delete a solution
     * @test
     * @return void
     */
    public function check_delete_solution()
    {
        //Error on delete
        $response = $this->delete('/api/solutions', ["id" => 5]  , $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/solutions', $this->solutions[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newSolutionId = $response->decodeResponseJson()['solution']['id'];

        //Sucess on delete
        $response = $this->delete('/api/solutions',  ["id" => $newSolutionId] , $this->getRequestHeaders());
        $response->assertStatus(200);
    
        //Error on delete
        $response = $this->delete('/api/solutions',  ["id" => $newSolutionId] , $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one solution
     * @test
     * @return void
     */
    public function check_get_solution_item()
    {
        //Error on get
        $response = $this->get('/api/solutions/5');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/solutions', $this->solutions[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newSolutionId = $response->decodeResponseJson()['solution']['id'];
        
        //Sucess on get
        $response = $this->get("/api/solutions/{$newSolutionId}",  $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newSolutionId, $response->decodeResponseJson()['solution']['id']);
        $this->assertEquals($this->solutions[0]['title'], $response->decodeResponseJson()['solution']['title']);
    
        //Error on get
        $response = $this->get('/api/solutions/5', $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one solution
     * @test
     * @return void
     */
    public function check_get_solution_items()
    {
        //Error
        $response = $this->get('/api/solutions');
        $response->assertStatus(200);

        // //login
        $this->userLogin();

        //get solutions
        $response = $this->get('/api/solutions', $this->getRequestHeaders());
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));

        //Sucess
        foreach ($this->solutions as $c => $cat) {
            $response = $this->post('/api/solutions', [
                'title' => $cat['title'],
                'text' => $cat['text'],
                'images_id' => $cat['images_id'],
                'active' => $cat['active']
            ], $this->getRequestHeaders());
            $this->assertEquals(ucfirst($this->solutions[$c]['title']), $response->decodeResponseJson()['solution']['title']);
        }

        //get solutions
        $response = $this->get('/api/solutions?page=1', $this->getRequestHeaders());
        $this->assertEquals(1, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(3, count($response->decodeResponseJson()['data']));

        $response = $this->get('/api/solutions?page=2', $this->getRequestHeaders());
        $this->assertEquals(2, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));
        $this->assertEquals(3, $response->decodeResponseJson()['total']);
    }
}
