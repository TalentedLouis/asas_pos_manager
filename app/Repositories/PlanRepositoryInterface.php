<?php

namespace App\Repositories;

use App\Models\Plan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanRepositoryInterface
{
    /**
     * @param int $id
     * @return Plan
     */
    public function get(int $id): Plan;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Plan
     */
    public function newEntity(): Plan;

    /**
     * @param Plan $entity
     * @return bool
     */
    public function save(Plan $entity): bool;

    /**
     * @param Plan $entity
     * @return bool|null
     */
    public function delete(Plan $entity): ?bool;
}
