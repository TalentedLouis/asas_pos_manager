<?php

namespace App\Services;

use App\Repositories\MakerRepositoryInterface;
use Illuminate\Support\Collection;

class MakerService
{
    private MakerRepositoryInterface $repository;

    public function __construct(MakerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelect(): Collection
    {
        return $this->repository->getSelect();
    }
}
