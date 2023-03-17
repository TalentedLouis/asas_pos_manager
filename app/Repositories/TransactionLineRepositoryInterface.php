<?php

namespace App\Repositories;

use App\Models\TransactionLine;
use Illuminate\Support\Collection;

interface TransactionLineRepositoryInterface
{
    public function newEntity(): TransactionLine;

    public function save(TransactionLine $entity): bool;

    public function findBySlipId(int $slipId): ?Collection;

    public function deleteLines(int $slipId): ?bool;

    public function delete(TransactionLine $entity): ?bool;
}
