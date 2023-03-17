<?php

namespace App\UseCases;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Repositories\RoomRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class RoomActions
{
    private RoomRepositoryInterface $repository;

    /**
     * @param RoomRepositoryInterface $repository
     */
    public function __construct(RoomRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Room
     */
    public function get(int $id): Room
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
     * @param Room $entity
     * @param RoomRequest $post
     * @return bool
     */
    public function update(Room $entity, RoomRequest $post): bool
    {
        $entity->shop_id = Auth::user()->shop->id;
        $entity->name = $post->name;
        $entity->type_id = $post->type_id;
        $entity->smoking_type_id = $post->smoking_type_id;
        $entity->pc_type_id = $post->pc_type_id;
        return $this->repository->save($entity);
    }

    /**
     * @param Room $entity
     * @return bool|null
     */
    public function delete(Room $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
