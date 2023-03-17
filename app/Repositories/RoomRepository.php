<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class RoomRepository implements RoomRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Room
    {
        return Room::find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return Room::where("shop_id", Auth::user()->shop->id)
            ->orderBy("id")
            ->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Room
    {
        return new Room();
    }

    /**
     * @inheritDoc
     */
    public function save(Room $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Room $entity): ?bool
    {
        return $entity->delete();
    }

    /**
     * @inheritDoc
     */
    public function getSelect(): Collection
    {
        return Room::orderBy("id")->pluck("name", "id");
    }
}
