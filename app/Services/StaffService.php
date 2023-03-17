<?php

namespace App\Services;

use App\Models\Staff;
use App\Repositories\StaffRepositoryInterface;

class StaffService
{
    private StaffRepositoryInterface $repository;

    public function __construct(StaffRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get($id): ?Staff
    {
        return $this->repository->get($id);
    }
}
