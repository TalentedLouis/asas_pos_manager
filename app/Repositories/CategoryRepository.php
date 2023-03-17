<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table('categories')->whereNull('deleted_at')->orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Category
    {
        return new Category();
    }

    /**
     * @inheritDoc
     */
    public function save(Category $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Category $entity): ?bool
    {
        return $entity->delete();
    }

    public function getSelect(): Collection
    {
        return DB::table('categories')->whereNull('deleted_at')->orderBy('id')->pluck('name', 'id');
    }
}
