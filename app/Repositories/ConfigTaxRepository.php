<?php

namespace App\Repositories;

use App\Models\ConfigTax;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ConfigTaxRepository implements ConfigTaxRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): ?ConfigTax
    {
        return ConfigTax::find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return ConfigTax::orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): ConfigTax
    {
        return new ConfigTax();
    }

    /**
     * @inheritDoc
     */
    public function save(ConfigTax $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(ConfigTax $entity): ?bool
    {
        return $entity->delete();
    }

    public function getNow(): ConfigTax
    {
        $now = Carbon::now()->format('Y-m-d');
        return ConfigTax::where('started_on', '<=', $now)->orderBy('started_on', 'desc')->first();
    }
}
