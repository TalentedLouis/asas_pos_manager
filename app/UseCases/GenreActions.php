<?php

namespace App\UseCases;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use App\Repositories\GenreRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GenreActions
{
    private GenreRepositoryInterface $repository;

    /**
     * @param GenreRepositoryInterface $repository
     */
    public function __construct(GenreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Genre
     */
    public function get(int $id): Genre
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
     * @param GenreRequest $post
     */
    public function create(GenreRequest $post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param Genre $entity
     * @param GenreRequest $post
     * @return bool
     */
    public function update(Genre $entity, GenreRequest $post): bool
    {
        $entity->code = $post->code;
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    /**
     * @param Genre $entity
     * @return bool|null
     */
    public function delete(Genre $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
