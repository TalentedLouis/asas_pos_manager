<?php

namespace App\UseCases;

use App\Http\Requests\StaffRequest;
use App\Models\Staff;
use App\Repositories\StaffRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class StaffActions
{
    private StaffRepositoryInterface $repository;

    /**
     * @param StaffRepositoryInterface $repository
     */
    public function __construct(StaffRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Staff
     */
    public function get(int $id): Staff
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
     * @param Staff $entity
     * @param StaffRequest $post
     * @return bool
     */
    public function update(Staff $entity, StaffRequest $post): bool
    {
        $entity->shop_id = Auth::user()->shop->id;
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    /**
     * @param Staff $entity
     * @return bool|null
     */
    public function delete(Staff $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
