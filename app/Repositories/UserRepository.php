<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): User
    {
        return User::select()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return User::select()->orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): User
    {
        return new User();
    }

    /**
     * @inheritDoc
     */
    public function save(User $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(User $entity): ?bool
    {
        return $entity->delete();
    }
}
