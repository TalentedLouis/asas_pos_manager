<?php

namespace App\UseCases;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerActions
{
    private CustomerRepositoryInterface $repository;

    /**
     * @param CustomerRepositoryInterface $repository
     */
    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Customer
     */
    public function get(int $id): Customer
    {
        return $this->repository->get($id);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->repository->all();
    }

    /**
     * @param CustomerRequest $post
     */
    public function create(CustomerRequest $post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param Customer $entity
     * @param CustomerRequest $post
     * @return bool
     */
    public function update(Customer $entity, CustomerRequest $post): bool
    {
        $entity->code = $post->code;
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    /**
     * @param Customer $entity
     * @return bool|null
     */
    public function delete(Customer $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
