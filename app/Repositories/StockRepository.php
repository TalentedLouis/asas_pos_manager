<?php

namespace App\Repositories;

use App\Enums\TransactionType;
use App\Models\Stock;
use App\Models\TransactionSlip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Enums\TaxableMethodType;
use App\Enums\TaxRateType;

class StockRepository implements StockRepositoryInterface
{
    public function newEntity(): Stock
    {
        return new Stock();
    }

    public function newKariEntity(): Stock
    {
        $entity = new Stock();
        $entity->sell_tax_rate_type_id = TaxRateType::EXCLUDED;
        $entity->sell_taxable_method_type_id = TaxableMethodType::STANDARD_TAX;
        $entity->stocking_tax_rate_type_id = TaxRateType::EXCLUDED;
        $entity->stocking_taxable_method_type_id = TaxableMethodType::STANDARD_TAX;
        return $entity;
    }

    public function save(Stock $entity): bool
    {
        return $entity->save();
    }

    public function getOne(int $productId): ?Stock
    {
        $result = Stock::where('product_id', $productId)
            ->where('shop_id', Auth::user()->shop->id)
            ->get();
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    /**
     * @param TransactionSlip $slip
     * @param bool $is_delete
     * @return bool
     */
    public function changeStock(TransactionSlip $slip, $is_delete = false): bool
    {
        $transaction_type_id = $slip->transaction_type_id;
        $lines = $slip->transaction_lines;
        foreach ($lines as $line) {
            $stock = $this->getOne($line->product_id);
            if ($transaction_type_id == TransactionType::SALES || $transaction_type_id == TransactionType::EXIT_STOCK) {
                // 売上 or 出庫
                if (!$is_delete) {
                    // 在庫数
                    $stock->this_stock_quantity = (int)$stock->this_stock_quantity - (int)$line->quantity;
                } else {
                    //
                    $stock->this_stock_quantity = (int)$stock->this_stock_quantity + (int)$line->quantity;
                }
            } elseif ($transaction_type_id == TransactionType::PURCHASE || $transaction_type_id == TransactionType::ENTRY_STOCK) {
                // 仕入 or 入庫
                if ($is_delete == false) {
                    // 在庫数
                    $stock->this_stock_quantity = (int)$stock->this_stock_quantity + (int)$line->quantity;
                    // 平均原価
                    if ($stock->this_stock_quantity == 0){
                        $stock->avg_stocking_price = 0;    
                    } else {
                        $stock->avg_stocking_price =
                            ((int)$line->quantity * (int)$line->final_unit_price_tax_excluded +
                                (int)$stock->this_stock_quantity * (float)$stock->avg_stocking_price) /
                            (int)$stock->this_stock_quantity;
                    }
                } else {
                    // 在庫数
                    $stock->this_stock_quantity = (int)$stock->this_stock_quantity - (int)$line->quantity;
                }
            }
            $this->save($stock);
        }
        return true;
    }
}
