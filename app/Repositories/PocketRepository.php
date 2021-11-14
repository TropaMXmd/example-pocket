<?php

namespace App\Repositories;

class PocketRepository extends Repository {
 
    /**
     * Specify Model class name
     *
     * @return class name
     */
    function model()
    {
        return 'App\Models\Pocket';
    }

}

?>