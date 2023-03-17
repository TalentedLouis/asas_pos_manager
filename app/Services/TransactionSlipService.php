<?php

namespace App\Services;

use App\Repositories\ShopConfigRepositoryInterface;
use App\Traits\BarcodeTrait;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Date;

class TransactionSlipService
{
    use BarcodeTrait;
    private $shopConfigRepository;
    public function __construct(
        ShopConfigRepositoryInterface $shopConfigRepository
    )
    {
        $this->shopConfigRepository=$shopConfigRepository;
    }

    public function newSlipNumber()
    {
        // Get slip_number_sequence
        $shopConfig = $this->shopConfigRepository->getOne();
        if ($shopConfig == null) {
            throw new RecordsNotFoundException('自店情報を追加してください。');
        }
        $shopConfig->slip_number_sequence = $shopConfig->slip_number_sequence + 1;
        $this->shopConfigRepository->save($shopConfig);

        return $this->newBarcodeJan13(
            $shopConfig->slip_number_sequence,
            Date::now()->format('Y')
        );
    }
}
