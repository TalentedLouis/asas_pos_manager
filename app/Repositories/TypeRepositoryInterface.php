<?php

namespace App\Repositories;

use App\Models\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TypeRepositoryInterface
{
    /**
     * @param int $id
     * @return Type
     */
    public function get(int $id): Type;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Type
     */
    public function newEntity(): Type;

    /**
     * @param Type $entity
     * @return bool
     */
    public function save(Type $entity): bool;

    /**
     * @param Type $entity
     * @return bool|null
     */
    public function delete(Type $entity): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;
}
