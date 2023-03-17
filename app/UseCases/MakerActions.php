<?php

namespace App\UseCases;

use App\Http\Requests\MakerRequest;
use App\Models\Maker;
use App\Repositories\MakerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MakerActions
{
    private MakerRepositoryInterface $repository;

    /**
     * @param MakerRepositoryInterface $repository
     */
    public function __construct(MakerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Maker
     */
    public function get(int $id): Maker
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
     * @param MakerRequest $post
     */
    public function create(MakerRequest $post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param Maker $entity
     * @param MakerRequest $post
     * @return bool
     */
    public function update(Maker $entity, MakerRequest $post): bool
    {
        $entity->code = $post->code;
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    /**
     * @param Maker $entity
     * @return bool|null
     */
    public function delete(Maker $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
