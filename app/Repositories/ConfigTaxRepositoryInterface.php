<?php

namespace App\Repositories;

use App\Models\ConfigTax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ConfigTaxRepositoryInterface
{
    /**
     * @param int $id
     * @return ConfigTax|null
     */
    public function get(int $id): ?ConfigTax;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return ConfigTax
     */
    public function newEntity(): ConfigTax;

    /**
     * @param ConfigTax $entity
     * @return bool
     */
    public function save(ConfigTax $entity): bool;

    /**
     * @param ConfigTax $entity
     * @return bool|null
     */
    public function delete(ConfigTax $entity): ?bool;

    /**
     * @return ConfigTax
     */
    public function getNow(): ConfigTax;
}
