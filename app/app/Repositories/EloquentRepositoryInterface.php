<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

interface EloquentRepositoryInterface
{
    /**
     * Get all models.
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Paginate all models.
     */
    public function paginate(array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * Get all trashed models.
     */
    public function allTrashed(): Collection;

    /**
     * Find model by id.
     */
    public function findById(
        int $id,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;

    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): ?Model;

    public function getByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Collection;

    /**
     * Find trashed model by id.
     *
     * @throws ModelNotFoundException
     */
    public function findTrashedById(int $id): Model;

    /**
     * Find only trashed model by id.
     *
     * @throws ModelNotFoundException
     */
    public function findOnlyTrashedById(int $id): Model;

    /**
     * Create a model.
     */
    public function create(array|Data $attributes): Model;

    /**
     * Update existing model.
     */
    public function update(Model $model, array|Data $attributes): Model;

    /**
     * Delete model by id.
     */
    public function deleteById(int $id): bool;

    /**
     * Delete model.
     */
    public function delete(Model $model): void;

    /**
     * Restore model by id.
     */
    public function restoreById(int $id): bool;

    /**
     * Permanently delete model by id.
     */
    public function permanentlyDeleteById(int $id): bool;

    public function newQuery(): Builder;
}
