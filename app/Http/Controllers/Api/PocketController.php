<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\PocketService;
use App\Http\Requests\PocketRequest;

class PocketController extends ApiController
{
    /**
     * @var
     */
    protected $pocketService;

    /**
     *
     * @param  object  $pocketService
     * @return void
     *
     */
    public function __construct(PocketService $pocketService)
    {
        $this->pocketService = $pocketService;
    }

    /**
    * Add a new pocket
    *
    * @param  object  $request
    * @return json response
    *
    */
    public function store(PocketRequest $request)
    {
        $pocket = $this->pocketService->add($request);
        if ($pocket) 
            return $this->respond('Pocket created successfully!', 'success', 201, $pocket);
        
        return $this->errorResponse(400, $pocket);
    }

    /**
    * Get all contents by pocket id
    *
    * @param  int  $pocketId
    * @return json response
    *
    */
    public function getContentsByPocketId($pocketId)
    {
        $pocket = $this->pocketService->getAllContentsByPocketId($pocketId);
        if ($pocket) 
            return $this->respond('List of Contents of a pocket!', 'success', 200, $pocket);
        
        return $this->errorResponse(400, $pocket);  
    }
}
