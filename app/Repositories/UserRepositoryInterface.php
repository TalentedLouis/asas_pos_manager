<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User
     */
    public function get(int $id): User;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return User
     */
    public function newEntity(): User;

    /**
     * @param User $entity
     * @return bool
     */
    public function save(User $entity): bool;

    /**
     * @param User $entity
     * @return bool|null
     */
    public function delete(User $entity): ?bool;
}
