<?php

namespace App\Repositories;

use App\Models\Staff;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface StaffRepositoryInterface
{
    /**
     * @param int $id
     * @return Staff
     */
    public function get(int $id): ?Staff;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Staff
     */
    public function newEntity(): Staff;

    /**
     * @param Staff $entity
     * @return bool
     */
    public function save(Staff $entity): bool;

    /**
     * @param Staff $entity
     * @return bool|null
     */
    public function delete(Staff $entity): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;
}
