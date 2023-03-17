<?php

namespace App\Repositories;

use App\Models\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TypeRepository implements TypeRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Type
    {
        return DB::table("types")
            ->whereNull("deleted_at")
            ->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table("types")
            ->whereNull("deleted_at")
            ->orderBy("id")
            ->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Type
    {
        return new Type();
    }

    /**
     * @inheritDoc
     */
    public function save(Type $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Type $entity): ?bool
    {
        return $entity->delete();
    }

    /**
     * @inheritDoc
     */
    public function getSelect(): Collection
    {
        return Type::orderBy("id")->pluck("name", "id");
    }
}
