<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Dashborad check timeline
     * @test
     * @return void
     */
    public function check_timeline()
    {
        $this->withExceptionHandling();

        //Error dont logged
        $response = $this->post('/api/dashboard/timeline');
        $response->assertStatus(403);

        $this->userLogin();

        //Sucess on get
        $response = $this->post('/api/dashboard/timeline', [
            "filter" => [
                "key" => "all-period",
                "name" => "Todo o Período",
                "period" => [
                    "start" => "2000-01-01 00:00:00", 
                    "end" => "2022-04-08 23:59:59"
                ],
            ]
        ], $this->getRequestHeaders());

        $response->assertStatus(200);
    }


    /**
     * Dashborad check navegations
     * @test
     * @return void
     */
    public function check_navegations()
    {
        $this->withExceptionHandling();

        //Error dont logged
        $response = $this->post('/api/dashboard/navegations');
        $response->assertStatus(403);

        $this->userLogin();

        //Sucess on get
        $response = $this->post('/api/dashboard/navegations', [
            "filter" => [
                "key" => "all-period",
                "name" => "Todo o Período",
                "period" => [
                    "start" => "2000-01-01 00:00:00", 
                    "end" => "2022-04-08 23:59:59"
                ],
            ]
        ], $this->getRequestHeaders());
        
        $response->assertStatus(200);
    }

    
}
