<?php

namespace App\Repositories;

use App\Models\Maker;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MakerRepositoryInterface
{
    /**
     * @param int $id
     * @return Maker
     */
    public function get(int $id): Maker;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Maker
     */
    public function newEntity(): Maker;

    /**
     * @param Maker $entity
     * @return bool
     */
    public function save(Maker $entity): bool;

    /**
     * @param Maker $entity
     * @return bool|null
     */
    public function delete(Maker $entity): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;
}
