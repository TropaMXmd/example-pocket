<?php

namespace App\Repositories;

class ContentRepository extends Repository {
 
    /**
     * Specify Model class name
     *
     * @return class name
     */
    function model()
    {
        return 'App\Models\Content';
    }

    /**
     * Delete a record by id
     * and detach relationships
     * 
     * @param $id
     * @return mixed
     */
    public function deleteContent($id)
    {
        $result = $this->find($id);
        if(!$result) return false;

        $result->keywords()->detach();
        return $result->delete();
    }

}

?>