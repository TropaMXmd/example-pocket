<?php

namespace App\Repositories;
 
use App\Repositories\Contracts\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
 
abstract class Repository implements RepositoryInterface {
    /**
     * @var App
     */
    private $app;
 
    /**
     * @var
     */
    protected $model;

    /**
     * @param App $app
     * @throws Exception
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }
 
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * Fetch all records
     * 
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')) {
        return $this->model->get($columns);
    }
 
    /**
     * Fetch all records using pagination
     * 
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Create new record
     * 
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * Create new record if not found
     * 
     * @param array $data
     * @return mixed
     */
    public function findOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }
  
    /**
     * Update record
     * 
     * 
     * @param array $data
     * @param int $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * Delete a record by id
     * 
     * @param int $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }
 
    /**
     * Find a record by id
     * 
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->find($id, $columns);
    }

    /**
     * Find a record by attribute
     * 
     * @param string $attribute
     * @param string|int $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * Find all records by attribute
     * 
     * @param string $attribute
     * @param string|int $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->select($columns)->get();
    }

    /**
     * Find all records with relationships by attribute
     * 
     * @param string $attribute
     * @param string|int $value
     * @param string $relation
     * @return mixed
     */
    public function findWhereIn($attribute, array $value, $relation) {
        return $this->model->whereIn($attribute, $value)->with($relation)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws Exception
     */
    public function makeModel() {
        $model = $this->app->make($this->model());
 
        if (!$model instanceof Model)
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
            //throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
 
        return $this->model = $model->newQuery();
    }
}

?>