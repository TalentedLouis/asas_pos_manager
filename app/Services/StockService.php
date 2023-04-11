<?php

namespace App\Services;

use App\Models\Stock;
use App\Repositories\StockRepositoryInterface;

class StockService
{
    private $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function getThisStock(int $productId): ?Stock
    {
        return $this->stockRepository->getOne($productId);
    }

    public function getOtherStock(int $productId): ?Stock
    {
        return $this->stockRepository->getOtherOne($productId);
    }

    public function getKariStock(): ?Stock
    {
        return $this->stockRepository->newKariEntity();
    }
}
