<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CustomerRepositoryInterface
{
    /**
     * @param int $id
     * @return Customer
     */
    public function get(int $id): Customer;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Customer
     */
    public function newEntity(): Customer;

    /**
     * @param string $name
     * @return Customer|null
     */
    public function findByName(string $name): LengthAwarePaginator;


    /**
     * @param Customer $entity
     * @return bool
     */
    public function save(Customer $entity): bool;

    /**
     * @param Customer $entity
     * @return bool|null
     */
    public function delete(Customer $entity): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;

    /**
     * @param string $code
     * @return Customer|null
     */
    public function findByCode(string $code): ?Customer;
}
