<?php

namespace App\Repositories;

use App\Models\ShopConfig;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ShopConfigRepositoryInterface
{
    /**
     * @param int $id
     * @return ShopConfig
     */
    public function get(int $id): ShopConfig;

    /**
     * @return ShopConfig|null
     */
    public function getOne(): ?ShopConfig;

    /**
     * @return ShopConfig
     */
    public function newEntity(): ShopConfig;

    /**
     * @param ShopConfig $entity
     * @return bool
     */
    public function save(ShopConfig $entity): bool;

    /**
     * @param ShopConfig $entity
     * @return bool|null
     */
    public function delete(ShopConfig $entity): ?bool;

}
