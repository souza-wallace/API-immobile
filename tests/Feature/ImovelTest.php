<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImovelTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_endpoint_get_is_working()
    {
        $response = $this->getJson('/api/v1/realStates');

        $response->assertStatus(200);
    }

    public function test_endpoint_get_return_different_of_empty()
    {
        $response = $this->getJson('/api/v1/realStates');

        $this->assertNotEmpty($response);

    }

    public function test_endpoint_store_is_saving()
    {
        $response = $this->post('/api/v1/realStates', [
            "title" => "saving api test",
            "description" => "apenas teste",
            "content" => "teste",
            "price" => 20000,
            "bathrooms" => 2,
            "property_area" => 1,
            "total_property_area" => 1,
            "slug" => "teste",       
            "categories[]" => 1,
            "user_id" => 1,
        ]);

        $response->assertStatus(201);

    }
}
