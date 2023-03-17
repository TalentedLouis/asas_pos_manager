<?php

namespace App\Repositories;

use App\Models\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ShopRepository implements ShopRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function get(int $id): Shop
    {
        return DB::table('shops')->whereNull('deleted_at')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table('shops')->whereNull('deleted_at')->orderBy('code')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Shop
    {
        return new Shop();
    }

    /**
     * @inheritDoc
     */
    public function save(Shop $shop): bool
    {
        return $shop->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Shop $shop): ?bool
    {
        return $shop->delete();
    }

    public function getSelect(): Collection
    {
        return DB::table('shops')
            ->whereNull('deleted_at')
            ->orderBy('code')->pluck('name', 'id');
    }
}
