<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class BaseRepository implements EloquentRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->newQuery()->with($relations)->get($columns);
    }

    public function paginate(array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        $perPage = request()->integer('per_page', 15);

        return $this->newQuery()->with($relations)->select($columns)->paginate($perPage);
    }

    public function allTrashed(): Collection
    {
        return $this->newQuery()->onlyTrashed()->get();
    }

    public function findTrashedById(int $id): Model
    {
        return $this->newQuery()->withTrashed()->findOrFail($id);
    }

    public function findOnlyTrashedById(int $id): Model
    {
        return $this->newQuery()->onlyTrashed()->findOrFail($id);
    }

    public function findById(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->findByCriteria(['id' => $id], $columns, $relations);
    }

    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->newQuery()->select($columns)->with($relations)->where($criteria)->first();
    }

    public function getByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Collection
    {
        return $this->newQuery()->select($columns)->with($relations)->where($criteria)->get();
    }

    public function create(array|Data $attributes): Model
    {
        if (! is_array($attributes)) {
            $attributes = $attributes->toArray();
        }

        return $this->newQuery()->create($attributes);
    }

    public function update(Model $model, array|Data $attributes): Model
    {
        if (! is_array($attributes)) {
            $attributes = $attributes->toArray();
        }

        return tap($model)->update($attributes);
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }

    public function deleteById(int $id): bool
    {
        return $this->findById($id)->delete();
    }

    public function restoreById(int $id): bool
    {
        return $this->findOnlyTrashedById($id)->restore();
    }

    public function permanentlyDeleteById(int $id): bool
    {
        return $this->findTrashedById($id)->forceDelete();
    }

    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }
}
