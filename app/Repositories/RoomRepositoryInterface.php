<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RoomRepositoryInterface
{
    /**
     * @param int $id
     * @return Room
     */
    public function get(int $id): Room;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Room
     */
    public function newEntity(): Room;

    /**
     * @param Room $entity
     * @return bool
     */
    public function save(Room $entity): bool;

    /**
     * @param Room $entity
     * @return bool|null
     */
    public function delete(Room $entity): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;
}
