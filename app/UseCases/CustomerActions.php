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
     * @return LengthAwarePaginator
     */
    public function findByName(string $name): LengthAwarePaginator
    {
        return $this->repository->findByName($name);
    }

    /**
     * @param string $code
     * @return Customer|null
     */
    public function findByCode(string $code): ?Customer
    {
        return $this->repository->findByCode($code);
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
        $entity->read = $post->read;
        $entity->sex = $post->sex;
        $entity->birthday = $post->birthday;
        $entity->zip_code = $post->zip_code;
        $entity->address_1 = $post->address_1;
        $entity->address_2 = $post->address_2;
        $entity->address_3 = $post->address_3;
        $entity->tel = $post->tel;
        $entity->portable = $post->portable;
        $entity->note = $post->note;
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
