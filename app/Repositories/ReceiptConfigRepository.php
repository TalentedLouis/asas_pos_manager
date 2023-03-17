<?php

namespace App\Repositories;

use App\Models\ReceiptConfig;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ReceiptConfigRepository implements ReceiptConfigRepositoryInterface
{
    public function all(): Collection
    {
        return ReceiptConfig::all();
    }

    /**
     * @return ReceiptConfig|null
     */
    public function getOne(): ?ReceiptConfig
    {
        $result = ReceiptConfig::select()
            ->where('shop_id', Auth::user()->shop->id)
            ->orderBy('id')
            ->limit(1)
            ->get();
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    public function newEntity(): ReceiptConfig
    {
        return new ReceiptConfig();
    }

    public function save(ReceiptConfig $receiptConfig): bool
    {
        return $receiptConfig->save();
    }

    public function delete(ReceiptConfig $entity): ?bool
    {
        return $entity->delete();
    }
}
