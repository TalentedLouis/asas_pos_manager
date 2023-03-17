<?php

namespace App\Repositories;

use App\Models\ShopConfig;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ShopConfigRepository implements ShopConfigRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function get(int $id): ShopConfig
    {
        return ShopConfig::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getOne(): ?ShopConfig
    {
        $result = ShopConfig::where("shop_id", Auth::user()->shop->id)->limit(1)->get();
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): ShopConfig
    {
        return new ShopConfig();
    }

    /**
     * @inheritDoc
     */
    public function save(ShopConfig $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(ShopConfig $entity): ?bool
    {
        return $entity->delete();
    }
}
