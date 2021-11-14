<?php

namespace Tests\Feature;

use Tests\TestCase;

class PocketTest extends TestCase
{
    /**
     * Check validation: title is required.
     *
     * @return void
     */
    public function test_title_required_validation_create_pocket()
    {
        $this->withExceptionHandling();
        $response = $this->post('/api/pocket', [
            'description' => 'Test description'
        ]);
        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Validation error',
                    'error' => [
                        'title' => [
                            'Please insert a valid pocket title!'
                        ]
                    ]
                ]);
    }

    /**
     *  Check validation: title and description must be alphanumeric.
     *
     * @return void
     */
    public function test_title_alphanumeric_validation_create_pocket()
    {
        $this->withExceptionHandling();
        $response = $this->post('/api/pocket', [
            'title' => '<? Test Title ?>',
            'description' => 'Test description ?>'
        ]);
        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Validation error',
                    'error' => [
                        'title' => [
                            'Please insert a alphanumeric title!'
                        ],
                        'description' => [
                            'Please insert a alphanumeric description!'
                        ],
                    ]
                ]);
    }

    /**
     *  Test create pocket api.
     *
     * @return void
     */
    public function test_create_pocket()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/pocket', [
            'title' => 'Johns pocket',
            'description' => 'Test description'
        ]);
        $response->assertStatus(201)
                ->assertJson([
                    'type' => 'success'
                ]);       
    }

    /**
     *  Get all contents by invalid pocket id.
     *
     * @return void
     */
    public function test_get_contents_by_invalid_pocket_id()
    {
        $pocketId = 1000000;
        $this->withoutExceptionHandling();
        $response = $this->get('/api/pockets/'.$pocketId.'/contents');

        $response->assertStatus(400)
                ->assertJson([
                    'type' => 'error'
                ]);
    }
    /**
     *  Get all contents by valid pocket id.
     *
     * @return void
     */
    public function test_get_contents_by_pocket_id()
    {
        $pocketId = 1;
        $this->withoutExceptionHandling();
        $response = $this->get('/api/pockets/'.$pocketId.'/contents');

        $response->assertStatus(200)
                ->assertJson([
                    'type' => 'success'
                ]);
    }


}
