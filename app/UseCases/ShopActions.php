<?php

namespace App\UseCases;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use App\Repositories\ShopRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Traits\Json;

class ShopActions
{
    private ShopRepositoryInterface $repository;

    /**
     * @param ShopRepositoryInterface $repository
     */
    public function __construct(ShopRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Shop
     */
    public function get(int $id): Shop
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
     * @param Shop $entity
     * @param ShopRequest $post
     * @return bool
     */
    public function update(Shop $entity, ShopRequest $post): bool
    {
        $entity->code = $post->code;
        $entity->name = $post->name;
        return $this->repository->save($entity);
    }

    /**
     * @param Shop $entity
     * @return bool|null
     */
    public function delete(Shop $entity): ?bool
    {
        return $this->repository->delete($entity);
    }

    public function getAllJson()
    {
        $shops = $this->getAll();
        $response = [];
        foreach ($shops as $shop) {
            $row = [];
            $row["id"] = $shop->id;
            $row["code"] = $shop->code;
            $row["name"] = $shop->name;
            $response[] = $row;
        }
        return $response;
    }

    public function jsonUpload()
    {
        Json::create("shops.json", $this->getAllJson());
    }
}
