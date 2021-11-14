<?php

namespace App\Services;

use App\Repositories\PocketRepository;
use App\Http\Resources\PocketResource;

class PocketService
{
    /**
     * @var
     */
    protected $pocketRepository;

    /**
     *
     * @param  object  $pocketRepository
     * @return void
     *
     */
    public function __construct(PocketRepository $pocketRepository)
    {
        $this->pocketRepository = $pocketRepository;
    }

    /**
     * Create new pocket and
     * transform the resource into an array
     *
     * @param  object $request
     * @return array response
     *
     */
    public function add($request)
    {
        try {
            $data = $this->pocketRepository->create($request->all());
            return new PocketResource($data);
        } catch (\Exception $e) {
            app('log')->error('Pocket: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }

    /**
     * Find a pocket by id and
     * transform the resource into an array
     *
     * @param  int  $pocketId
     * @return array response
     *
     */
    public function getAllContentsByPocketId($pocketId)
    {
        try {
            $result = $this->pocketRepository->find($pocketId);
            if(!$result) return false;
            return new PocketResource($result);
        } catch (\Exception $e) {
            app('log')->error('Pocket: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }
}

?>