<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pocket;
use App\Models\Content;
use Database\Factories\ContentFactory;

class ContentTest extends TestCase
{
    /**
     * Check validation: title and url are required.
     *
     * @return void
     */
    public function test_title_and_url_required_validation_create_content()
    {
        $pocketId = 1;
        $this->withExceptionHandling();
        $response = $this->post('/api/pockets/'.$pocketId.'/content', [
            'description' => 'Test laravel content description',
            'keyword' => 'laravel'
        ]);
        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Validation error',
                    'error' => [
                        'title' => [
                            'Please insert a valid content title!'
                        ],
                        'url' => [
                            'Please insert a url!'
                        ]
                    ]
                ]);
    }

    /**
     *  Check validation: title ,description and keyword must be alphanumeric.
     *
     * @return void
     */
    public function test_title_description_keyword_alphanumeric_validation_create_content()
    {
        $pocketId = 1;
        $this->withExceptionHandling();
        $response = $this->post('/api/pockets/'.$pocketId.'/content', [
            'title' => '<? Test Title ?>',
            'description' => 'Test description ?>',
            'url' => 'https://www.youtube.com/watch?v=X7gyErx8_fs',
            'keyword' => '<?test'
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
                        'keyword' => [
                            'Please insert a alphanumeric keyword with no space!'
                        ],
                    ]
                ]);
    }

    /**
     *  Check validation: url must be valid and unique.
     *
     * @return void
     */
    public function test_url_unique_validation_create_content()
    {
        $pocketId = 1;
        $this->withExceptionHandling();
        $this->post('/api/pockets/'.$pocketId.'/content', [
            'title' => 'Test content title 1',
            'description' => 'Test description',
            'url' => 'https://www.youtube.com/watch?v=X7gyErx8_fs',
            'keyword' => 'laravel'
        ]);
        $response = $this->post('/api/pockets/'.$pocketId.'/content', [
            'title' => 'Test content title 2',
            'description' => 'Test description',
            'url' => 'https://www.youtube.com/watch?v=X7gyErx8_fs',
            'keyword' => 'laravel'
        ]);
        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Validation error',
                    'error' => [
                        'url' => [
                            'Please insert a unique url!'
                        ]
                    ]
                ]);
    }

    /**
     * Create a content
     *
     * @return void
     */
    public function test_pocket_id_invalid_create_content()
    {
        $pocketId = 10000;
        $this->withoutExceptionHandling();
        $response = $this->post('/api/pockets/'.$pocketId.'/content', [
            'title' => 'Title test php',
            'description' => 'Test php content description',
            'url' => 'https://www.youtube.com/watch?v=S6IfqDXWa10',
            'keyword' => 'php'
        ]);

        $response->assertStatus(400)
                ->assertJson([
                    'type' => 'error'
                ]);
    }

    /**
     * Create a content
     *
     * @return void
     */
    public function test_create_content()
    {
        $pocketId = 1;
        $this->withoutExceptionHandling();
        $response = $this->post('/api/pockets/'.$pocketId.'/content', [
            'title' => 'Title test php',
            'description' => 'Test php content description',
            'url' => 'https://www.youtube.com/watch?v=xd_79dTncAc&list=RDCMUC_UMEcP_kF0z4E6KbxCpV1w&index=2',
            'keyword' => 'php'
        ]);

        $response->assertStatus(201)
                ->assertJson([
                    'type' => 'success'
                ]);
    }

    /**
     * Get all contents with no keywords
     *
     * @return void
     */
    public function test_get_contents_without_keyword()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/contents');

        $response->assertStatus(200)
                ->assertJson([
                    'type' => 'success'
                ]);
        //$response->dump();
    }
    
    /**
     * Get all contents by single keyword
     *
     * @return void
     */
    public function test_get_contents_by_single_keyword()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/contents?keyword=php');

        $response->assertStatus(200)
                ->assertJson([
                    'type' => 'success'
                ]);
        //$response->dump();
    }

    /**
     * Get all contents by multiple keywords
     *
     * @return void
     */
    public function test_get_contents_by_multiple_keyword()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/contents?keyword=laravel,php');

        $response->assertStatus(200)
                ->assertJson([
                    'type' => 'success'
                ]);
        //$response->dump();
    }

    /**
     * Delete a content with invalid content id
     *
     * @return void
     */
    public function test_contentId_invalid_delete_content()
    {
        $contentId = 10000;
        $this->withoutExceptionHandling();
        $response = $this->delete('/api/contents/'.$contentId);

        $response->assertStatus(400)
                ->assertJson([
                    'type' => 'error'
                ]);

    }

    /**
     * Delete a content with invalid content id
     *
     * @return void
     */
    public function test_contentId_valid_delete_content()
    {
        $contentId = 1;
        $this->withoutExceptionHandling();
        $response = $this->delete('/api/contents/'.$contentId);

        $response->assertStatus(410)
                ->assertJson([
                    'type' => 'removed'
                ]);

    }
}
