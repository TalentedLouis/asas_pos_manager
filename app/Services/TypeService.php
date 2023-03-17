<?php

namespace App\Services;

use App\Repositories\TypeRepositoryInterface;
use Illuminate\Support\Collection;

class TypeService
{
    private TypeRepositoryInterface $repository;

    public function __construct(TypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelect(): Collection
    {
        return $this->repository->getSelect();
    }
}
