<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $contacts;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->contacts = Contact::factory()->count(10)->make()->toArray();
    }

    /**
     * Store a contact
     * @test
     * @return void
     */
    public function check_store_contact()
    {
        $this->withExceptionHandling();
        $this->contacts = Contact::factory()->count(2)->make()->toArray();

        //Error dont logged
        $response = $this->post('/api/contacts', $this->contacts[0]);
        $response->assertStatus(200);

        $this->userLogin();

        //Error on add
        $response = $this->post('/api/contacts', array_merge($this->contacts[0], ['name' => null]), $this->getRequestHeaders());
        $response->assertStatus(302);


        //Sucess new contact
        $newContactName = "Armando Nunes";
        $response = $this->post('/api/contacts', array_merge($this->contacts[0], ["name" => $newContactName, 'email' => 'armando@test.com', 'phone' => '81980000000']), $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newContactName, $response->decodeResponseJson()['contact']['name']);
    }


    /**
     * Delete a contact
     * @test
     * @return void
     */
    public function check_delete_contact()
    {
        //Error on delete
        $response = $this->delete('/api/contacts', ["id" => 5], $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/contacts', $this->contacts[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newContactId = $response->decodeResponseJson()['contact']['id'];

        //Sucess on delete
        $response = $this->delete('/api/contacts',  ["contacts_id" => [$newContactId]], $this->getRequestHeaders());
        $response->assertStatus(200);

        //Error on delete
        $response = $this->delete('/api/contacts',  ["contacts_id" => [$newContactId]], $this->getRequestHeaders());
        $response->assertStatus(404);
    }



    /**
     * Set status of contact
     * @test
     * @return void
     */
    public function check_status_contact()
    {
        //Error on status no logged
        $response = $this->post('/api/contacts/status', ["id" => 5], $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/contacts', $this->contacts[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newContactId = $response->decodeResponseJson()['contact']['id'];

        //Sucess on post
        $response = $this->post('/api/contacts/status',  ["contacts_id" => [$newContactId], 'status' => 'new'], $this->getRequestHeaders());
        $response->assertStatus(200);

        //Error on status
        $response = $this->post('/api/contacts/status',  ["contacts_id" => [200], 'status' => 'new'], $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Set star of contact
     * @test
     * @return void
     */
    public function check_set_star_contact()
    {
        //Error on status no logged
        $response = $this->post('/api/contacts/column/star', ["id" => 5], $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/contacts', $this->contacts[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newContactId = $response->decodeResponseJson()['contact']['id'];

        //Sucess on star
        $response = $this->post('/api/contacts/column/star',  ["contacts_id" => [$newContactId], 'value' => true], $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertTrue($response->decodeResponseJson()['success']);

        //Error on star
        $response = $this->post('/api/contacts/column/star',  ["contacts_id" => [201], 'value' => true], $this->getRequestHeaders());
        $response->assertStatus(404);
        $this->assertFalse($response->decodeResponseJson()['success']);
    }


    /**
     * Set archived of contact
     * @test
     * @return void
     */
    public function check_set_archived_contact()
    {
        //Error on star no logged
        $response = $this->post('/api/contacts/column/archived', ["id" => 7], $this->getRequestHeaders());
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/contacts', $this->contacts[1], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newContactId = $response->decodeResponseJson()['contact']['id'];

        //Sucess on archived
        $response = $this->post('/api/contacts/column/archived',  ["contacts_id" => [$newContactId], 'value' => true], $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertTrue($response->decodeResponseJson()['success']);

        //Error on archived
        $response = $this->post('/api/contacts/column/archived',  ["contacts_id" => [200], 'value' => true], $this->getRequestHeaders());
        $response->assertStatus(404);
        $this->assertFalse($response->decodeResponseJson()['success']);
    }



    /**
     * Get one contact
     * @test
     * @return void
     */
    public function check_get_contact()
    {
        //Error on get
        $response = $this->get('/api/contacts/5');
        $response->assertStatus(403);

        //login
        $this->userLogin();

        //Sucess add
        $response = $this->post('/api/contacts', $this->contacts[0], $this->getRequestHeaders());
        $response->assertStatus(200);
        $newContactId = $response->decodeResponseJson()['contact']['id'];

        //Sucess on get
        $response = $this->get("/api/contacts/{$newContactId}",  $this->getRequestHeaders());
        $response->assertStatus(200);
        $this->assertEquals($newContactId, $response->decodeResponseJson()['contact']['id']);
        $this->assertEquals($this->contacts[0]['name'], $response->decodeResponseJson()['contact']['name']);

        //Error on get
        $response = $this->get('/api/contacts/5', $this->getRequestHeaders());
        $response->assertStatus(404);
    }


    /**
     * Get one contact
     * @test
     * @return void
     */
    public function check_get_contacts()
    {
        //Error
        $response = $this->get('/api/contacts');
        $response->assertStatus(403);

        // //login
        $this->userLogin();

        //get contacts
        $response = $this->get('/api/contacts', $this->getRequestHeaders());
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));

        //Sucess
        foreach ($this->contacts as $c => $contact) {
            $response = $this->post('/api/contacts', $contact, $this->getRequestHeaders());
            $this->assertEquals($this->contacts[$c]['name'], $response->decodeResponseJson()['contact']['name']);
        }

        //get contacts
        $response = $this->get('/api/contacts?page=1', $this->getRequestHeaders());
        $this->assertEquals(1, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(10, count($response->decodeResponseJson()['data']));

        $response = $this->get('/api/contacts?page=2', $this->getRequestHeaders());
        $this->assertEquals(2, $response->decodeResponseJson()['current_page']);
        $this->assertEquals(0, count($response->decodeResponseJson()['data']));
        $this->assertEquals(10, $response->decodeResponseJson()['total']);
    }
}
