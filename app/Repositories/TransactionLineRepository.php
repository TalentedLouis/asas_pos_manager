<?php

namespace App\Repositories;

use App\Models\TransactionLine;
use Illuminate\Support\Collection;

class TransactionLineRepository implements TransactionLineRepositoryInterface
{
    private StockRepositoryInterface $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function newEntity(): TransactionLine
    {
        return new TransactionLine();
    }

    public function save(TransactionLine $entity): bool
    {
        return $entity->save();
    }

    public function findBySlipId(int $slipId): ?Collection
    {
        return TransactionLine::where('transaction_slip_id', $slipId)->get();
    }

    public function deleteLines(int $slipId): ?bool
    {
        $lines = $this->findBySlipId($slipId);
        if (is_null($lines)) {
            return null;
        }
        foreach ($lines as $line) {
            $this->delete($line);
        }
        return true;
    }

    public function delete(TransactionLine $entity): ?bool
    {
        return $entity->delete();
    }
}
