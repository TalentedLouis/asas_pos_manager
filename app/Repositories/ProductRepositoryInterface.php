<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    /**
     * @param int $id
     * @return Product|null
     */
    public function get(int $id): ?Product;

    /**
     * @param string $code
     * @return Product|null
     */
    public function findByCode(string $code): ?Product;

    /**
     * @param string $name
     * @return Product|null
     */
    public function findByName(string $name): LengthAwarePaginator;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return LengthAwarePaginator
     */
    public function all_this_stock(): LengthAwarePaginator;

    /**
     * @return Product
     */
    public function newEntity(): Product;

    /**
     * @param Product $entity
     * @return bool
     */
    public function save(Product $entity): bool;

    /**
     * @param Product $entity
     * @return bool|null
     */
    public function delete(Product $entity): ?bool;
}
