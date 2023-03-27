<?php

namespace App\Services;

use App\Models\SupplierTarget;
use App\Repositories\SupplierTargetRepositoryInterface;

class SupplierTargetService
{
    private SupplierTargetRepositoryInterface $repository;

    public function __construct(SupplierTargetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return SupplierTarget|null
     */
    public function get($id): ?SupplierTarget
    {
        return $this->repository->get($id);
    }

    /**
     * @param $id
     * @return SupplierTarget|null
     */
    public function getByCode($code): ?SupplierTarget
    {
        return $this->repository->findByCode($code);
    }
}
