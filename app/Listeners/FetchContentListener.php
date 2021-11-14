<?php

namespace App\Listeners;

use App\Events\FetchContentEvent;
use App\Services\ContentService;
use App\Services\WebScrapingService;
use Illuminate\Contracts\Queue\ShouldQueue;


class FetchContentListener implements ShouldQueue
{
    private $contentService;
    private $webScrapingService;
    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 5;
     /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 20;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ContentService $contentService, WebScrapingService $webScrapingService)
    {
        $this->contentService = $contentService;
        $this->webScrapingService = $webScrapingService;
    }

    /**
     * Handle the event.
     * Fetch data by web scraping
     * Update content information in db
     * 
     *
     * @param  FetchContentEvent  $event
     * @return void
     */
    public function handle(FetchContentEvent $event)
    {
        $result = $this->webScrapingService->setUrl($event->content->url)->getUrlContents();
        if($result) $this->contentService->update($result,$event->content->id);
    }
    
    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(FetchContentEvent $event, $exception)
    {
        //
    }

    public function retryUntil()
    {
        return now()->addMinutes(5);
    }
}
