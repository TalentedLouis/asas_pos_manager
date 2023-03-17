<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelect()
    {
        return $this->repository->getSelect();
    }

    public function get($id): ?Category
    {
        return $this->repository->get($id);
    }
}
