<?php

namespace App\Services;

use App\Repositories\ShopRepositoryInterface;
use Illuminate\Support\Collection;

class ShopService
{
    private ShopRepositoryInterface $repository;

    public function __construct(ShopRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelect(): Collection
    {
        return $this->repository->getSelect();
    }
}
