<?php

namespace App\Services;

use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Customer;

class CustomerService
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelect(): Collection
    {
        return $this->repository->getSelect();
    }

    public function get($id): ?Customer
    {
        return $this->repository->get($id);
    }

    public function getByCode($code): ?Customer
    {
        return $this->repository->findByCode($code);
    }
}
