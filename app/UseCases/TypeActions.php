<?php

namespace App\UseCases;

use App\Http\Requests\TypeRequest;
use App\Models\Type;
use App\Repositories\TypeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TypeActions
{
    private TypeRepositoryInterface $repository;

    /**
     * @param TypeRepositoryInterface $repository
     */
    public function __construct(TypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Type
     */
    public function get(int $id): Type
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
     * @param TypeRequest $post
     */
    public function create(TypeRequest $post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param Type $entity
     * @param TypeRequest $post
     * @return bool
     */
    public function update(Type $entity, TypeRequest $post): bool
    {
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    /**
     * @param Type $entity
     * @return bool|null
     */
    public function delete(Type $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
