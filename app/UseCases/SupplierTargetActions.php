<?php

namespace App\UseCases;

use App\Http\Requests\SupplierTargetRequest;
use App\Models\SupplierTarget;
use App\Repositories\SupplierTargetRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierTargetActions
{
    private SupplierTargetRepositoryInterface $repository;

    /**
     * @param SupplierTargetRepositoryInterface $repository
     */
    public function __construct(SupplierTargetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return SupplierTarget
     */
    public function get(int $id): SupplierTarget
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
     * @param $post
     */
    public function create($post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param SupplierTarget $entity
     * @param SupplierTargetRequest $post
     * @return bool
     */
    public function update(SupplierTarget $entity, SupplierTargetRequest $post): bool
    {
        $entity->code = $post->code;
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    public function delete(SupplierTarget $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
