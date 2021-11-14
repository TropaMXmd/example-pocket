<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\ContentService;
use App\Http\Requests\ContentRequest;
use Illuminate\Http\Request;

class ContentController extends ApiController
{
    /**
     * @var
     */
    protected $contentService;

    /**
     *
     * @param  object  $contentService
     * @return void
     *
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
    * Add a new content to a pocket
    *
    * @param  object $request
    * @param   int  $pocketId
    * @return json response
    *
    */
    public function store(ContentRequest $request, $pocketId)
    {
        $content = $this->contentService->add($request, $pocketId);
        if ($content) 
            return $this->respond('Content created successfully!', 'success', 201, $content);
        
        return $this->errorResponse(400, $content);
    }
    
    /**
    * Get all contents by a pocket id
    *
    * @param   int  $id
    * @return json response
    *
    */
    public function getContentsByPocketId($id)
    {
        $contents = $this->contentService->getAllContentsByPocketId($id);
        if ($contents) 
            return $this->respond('List of Contents!', 'success', 200, $contents);
        
        return $this->errorResponse(400, $contents);  
    }

    /**
    * Get all contents by single or multiple keywords
    * keywords will be sent as query param (example of single keyword: url?keyword=php)
    * keywords will be sent as query param (example of multiple keyword: url?keyword=php,laravel)
    * if no keyword query param is provided return all contents
    *
    * @param  object $request
    * @return json response
    *
    */
    public function getContentsByKeywords(Request $request)
    {
        $contents = $this->contentService->getAllContentsByKeywords($request);
        if ($contents) 
            return $this->respond('List of Contents by keywords!', 'success', 200, $contents);
        
        return $this->errorResponse(400, $contents);
    }

    /**
    * Delete a content by content id
    *
    * @param   int  $contentId
    * @return json response
    *
    */
    public function destroy($contentId)
    {
        $contents = $this->contentService->destroy($contentId);
        if ($contents) 
            return $this->respond('Content deleted successfully', 'removed', 410, $contents);
        
        return $this->errorResponse(400, $contents);
    }
}
