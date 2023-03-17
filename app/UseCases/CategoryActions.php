<?php

namespace App\UseCases;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryActions
{
    private CategoryRepositoryInterface $repository;

    /**
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Category
     */
    public function get(int $id): Category
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
     * @param Category $entity
     * @param CategoryRequest $post
     * @return bool
     */
    public function update(Category $entity, CategoryRequest $post): bool
    {
        //2023add s
        $entity->code = $post->code;
        //2023add s
        $entity->name = $post->name;
        $entity->point_rate = $post->point_rate;
        return $this->repository->save($entity);
    }

    public function delete(Category $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
