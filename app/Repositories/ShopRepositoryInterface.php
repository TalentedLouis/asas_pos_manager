<?php

namespace App\Repositories;

use App\Models\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ShopRepositoryInterface
{
    /**
     * @param int $id
     * @return Shop
     */
    public function get(int $id): Shop;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Shop
     */
    public function newEntity(): Shop;

    /**
     * @param Shop $shop
     * @return bool
     */
    public function save(Shop $shop): bool;

    /**
     * @param Shop $shop
     * @return bool|null
     */
    public function delete(Shop $shop): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;
}
