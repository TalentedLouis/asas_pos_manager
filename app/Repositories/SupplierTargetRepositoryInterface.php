<?php

namespace App\Repositories;

use App\Models\SupplierTarget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SupplierTargetRepositoryInterface
{
    /**
     * @param int $id
     * @return SupplierTarget|null
     */
    public function get(int $id): ?SupplierTarget;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return SupplierTarget
     */
    public function newEntity(): SupplierTarget;

    /**
     * @param SupplierTarget $entity
     * @return bool
     */
    public function save(SupplierTarget $entity): bool;

    /**
     * @param SupplierTarget $entity
     * @return bool|null
     */
    public function delete(SupplierTarget $entity): ?bool;
}
