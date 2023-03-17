<?php

namespace App\UseCases;

use App\Http\Requests\EntryExitTargetRequest;
use App\Models\EntryExitTarget;
use App\Repositories\EntryExitTargetRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EntryExitTargetActions
{
    private EntryExitTargetRepositoryInterface $repository;

    /**
     * @param EntryExitTargetRepositoryInterface $repository
     */
    public function __construct(EntryExitTargetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return EntryExitTarget
     */
    public function get(int $id): EntryExitTarget
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
     * @param EntryExitTarget $entity
     * @param EntryExitTargetRequest $post
     * @return bool
     */
    public function update(EntryExitTarget $entity, EntryExitTargetRequest $post): bool
    {
        $entity->code = $post->code;
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    public function delete(EntryExitTarget $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
