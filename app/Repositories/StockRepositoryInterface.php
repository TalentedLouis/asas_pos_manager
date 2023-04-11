<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Models\TransactionSlip;

interface StockRepositoryInterface
{
    /**
     * @return Stock
     */
    public function newEntity(): Stock;

    /**
     * @param Stock $entity
     * @return bool
     */
    public function save(Stock $entity): bool;

    /**
     * @param int $productId
     * @return Stock|null
     */
    public function getOne(int $productId): ?Stock;

    /**
     * @param int $productId
     * @return Stock|null
     */
    public function getOtherOne(int $productId): ?Stock;

    public function changeStock(TransactionSlip $slip, $is_delete): bool;
}
