<?php

namespace App\Services;

use App\Repositories\ContentRepository;
use App\Http\Resources\ContentResource;
use App\Repositories\KeywordRepository;
use App\Events\FetchContentEvent;
use App\Http\Resources\KeywordResource;

class ContentService
{
    /**
     * @var
     */
    protected $contentRepository;
    /**
     * @var
     */
    protected $keywordRepository;

    /**
     *
     * @param  object  $contentRepository
     * @param  object  $keywordRepository
     * @return void
     *
     */
    public function __construct(ContentRepository $contentRepository , KeywordRepository $keywordRepository)
    {
        $this->contentRepository = $contentRepository;
        $this->keywordRepository = $keywordRepository;
    }


    /**
     * Create new content,
     * attach a keyword(if available) to content,
     * dispatch event for fetching content and
     * transform the resource into an array
     *
     * @param  object  $request
     * @param  int  $pocketId
     * @return array response
     *
     */
    public function add($request, $pocketId)
    {
        try {
            $data = $request->all();
            $data['pocket_id'] = $pocketId;
            if($request->has('keyword'))
                $keyword = $this->keywordRepository->findOrCreate(['tag' => strtolower($request->get('keyword'))]);
        
            $result = $this->contentRepository->create($data);
            if($keyword) $result->keywords()->attach($keyword->id);
            FetchContentEvent::dispatch($result);
            return new ContentResource($result);
        } catch (\Exception $e) {
            app('log')->error('Content: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }

    /**
     * Find all contents by pocket id and
     * transform the resource into an array
     *
     * @param  int  $id
     * @return array response
     *
     */
    public function getAllContentsByPocketId($id)
    {
        try {
            $result = $this->contentRepository->findAllBy('pocket_id', $id);
            if(!$result) return false;
            return ContentResource::collection($result);
        } catch (\Exception $e) {
            app('log')->error('Content: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }


    /**
     * Find all contents by single or multiple keywords
     * transform the resource into an array
     *
     * @param object $request
     * @return array response
     *
     */
    public function getAllContentsByKeywords($request)
    {
        try {
            if($request->has('keyword')) {
                $tags = explode(',',strtolower($request->get('keyword')));
                $result = $this->keywordRepository->findWhereIn('tag', $tags, 'contents');
                return KeywordResource::collection($result);
            } else {
                $result = $this->contentRepository->paginate();
                return ContentResource::collection($result);
            }
        } catch (\Exception $e) {
            app('log')->error('Content: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }

    /**
    * Delete a content by content id
    *
    * @param   int $contentId
    * @return json response
    *
    */
    public function destroy($contentId)
    {
        try {
            return $this->contentRepository->deleteContent($contentId);
        } catch (\Exception $e) {
            app('log')->error('Content: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }

    /**
    * Update a content by content id
    *
    * @param  array $data
    * @param  int $contentId
    * @return json response
    *
    */
    public function update($data, $contentId)
    {
        try {
            return $this->contentRepository->update($data, $contentId);
        } catch (\Exception $e) {
            app('log')->error('Content: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }

    public function fetchUrlData($url)
    {
        
    }

}

?>