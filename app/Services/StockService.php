<?php

namespace App\Services;

use App\Models\Stock;
use App\Repositories\StockRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function getAllStocks(): LengthAwarePaginator
    {
       return $this->stockRepository->newKariEntity();
    }

    /**
    * @return LengthAwarePaginator
    */
    public function getAll(): LengthAwarePaginator
    {
       return $this->stockRepository->all();
    }

    public function updateThisStock(int $productId, int $stocks): bool
    {
        return $this->stockRepository->updateStock($productId, $stocks);
    }
}
