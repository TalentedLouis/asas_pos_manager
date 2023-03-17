<?php

namespace App\Repositories;

use App\Models\Staff;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class StaffRepository implements StaffRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): ?Staff
    {
        return Staff::find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return Staff::where("shop_id", Auth::user()->shop->id)
            ->orderBy("id")
            ->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Staff
    {
        return new Staff();
    }

    /**
     * @inheritDoc
     */
    public function save(Staff $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Staff $entity): ?bool
    {
        return $entity->delete();
    }

    /**
     * @inheritDoc
     */
    public function getSelect(): Collection
    {
        return Staff::orderBy("id")->pluck("name", "id");
    }
}
