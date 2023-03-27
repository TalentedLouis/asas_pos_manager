<?php

namespace App\Services;

use App\Models\EntryExitTarget;
use App\Repositories\EntryExitTargetRepositoryInterface;

class EntryExitTargetService
{
    private EntryExitTargetRepositoryInterface $repository;

    public function __construct(EntryExitTargetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return EntryExitTarget|null
     */
    public function get($id): ?EntryExitTarget
    {
        return $this->repository->get($id);
    }

    /**
     * @param $id
     * @return EntryExitTarget|null
     */
    public function getByCode($code): ?EntryExitTarget
    {
        return $this->repository->findByCode($code);
    }
}
