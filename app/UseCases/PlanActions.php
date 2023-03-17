<?php

namespace App\UseCases;

use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Repositories\PlanRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlanActions
{
    private PlanRepositoryInterface $repository;

    /**
     * @param PlanRepositoryInterface $repository
     */
    public function __construct(PlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Plan
     */
    public function get(int $id): Plan
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
     * @param PlanRequest $post
     */
    public function create(PlanRequest $post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param Plan $entity
     * @param PlanRequest $post
     * @return bool
     */
    public function update(Plan $entity, PlanRequest $post): bool
    {
        $entity->name = $post->name;
        $entity->use_minutes = $post->use_minutes;
        $entity->use_start_hour = $post->use_start_hour;
        $entity->use_limit_hour = $post->use_limit_hour;
        return $this->repository->save($entity);
    }

    /**
     * @param Plan $entity
     * @return bool|null
     */
    public function delete(Plan $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
