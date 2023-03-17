<?php

namespace App\Repositories;

use App\Models\TransactionSlip;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;

interface TransactionSlipRepositoryInterface
{
    public function get(int $id): ?TransactionSlip;

    public function findByDate($fromDate, $toDate,$transaction_type_id): LengthAwarePaginator;

    public function newEntity(): TransactionSlip;

    public function save(TransactionSlip $entity): bool;

    public function delete(TransactionSlip $entity): ?bool;
}
