<?php

namespace App\UseCases;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserActions
{
    private UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return User
     */
    public function get(int $id): User
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
     * @param User $entity
     * @param UserRequest $post
     * @return bool
     */
    public function update(User $entity, UserRequest $post): bool
    {
        $entity->name = $post->name;
        $entity->email = $post->email;
        $entity->shop_id = $post->shop_id;
        return $this->repository->save($entity);
    }

    /**
     * @param User $entity
     * @return bool|null
     */
    public function delete(User $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
