<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\PocketService;
use App\Services\WebScrapingService;

class WebController extends Controller
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
    * Get all contents by pocket id
    *
    * @param  int  $pocketId
    * @return view
    *
    */
    public function getContentsByPocket($pocketId)
    {
        $data = $this->pocketService->getAllContentsByPocketId($pocketId);
        return view('home',compact('data'));
    }
}
