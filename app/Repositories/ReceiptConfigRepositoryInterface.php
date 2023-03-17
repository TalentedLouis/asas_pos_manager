<?php

namespace App\Repositories;

use App\Models\ReceiptConfig;
use Illuminate\Support\Collection;

interface ReceiptConfigRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @return ReceiptConfig|null
     */
    public function getOne(): ?ReceiptConfig;

    /**
     * @return ReceiptConfig
     */
    public function newEntity(): ReceiptConfig;

    /**
     * @param ReceiptConfig $receiptConfig
     * @return bool
     */
    public function save(ReceiptConfig $receiptConfig): bool;

    public function delete(ReceiptConfig $entity): ?bool;
}
