<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     * @return Category|null
     */
    public function get(int $id): ?Category;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Category
     */
    public function newEntity(): Category;

    /**
     * @param Category $entity
     * @return bool
     */
    public function save(Category $entity): bool;

    /**
     * @param Category $entity
     * @return bool|null
     */
    public function delete(Category $entity): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;
}
