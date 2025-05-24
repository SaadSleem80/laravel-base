<?php 

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{ 
    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function fetchAll ($filters): array
    {
        $data = $this->model->orderBy($filters['order_by'] ?? 'id', $filters['order'] ?? 'asc');

        if($filters['paginate'])
            $data = $data->paginate(perPage: $filters['per_page'] ?? 10);

        return $data;
    } 

    public function find($id): array
    {
        $data = $this->model->find($id)->toArray();
        return $data;
    }

    public function create($request): array
    {
        $data = $this->model->create($request->all())->toArray();
        return $data;
    }

    public function update($request, $id): array
    {
        $data = $this->model->find($id);
        $data = $data->update($request->all());
        return $data->refresh()->toArray();
    }

    public function delete($id): void
    {
        $this->model->find($id)->delete();
    }
}