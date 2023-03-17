<?php

namespace App\Http\Livewire;

use App\Enums\TransactionType;
use App\Services\ProductService;
use App\Services\StockService;
use App\Services\TaxService;
use Livewire\Component;

class Product extends Component
{
    public $index;
    public $transaction_type;
    public $product_code;
    public $product_id;
    public $name = '';
    public $unit_price = '';
    public $tax_rate_type_id = '';
    public $taxable_method_type_id = '';
    public $final_unit_price_tax_included = '';
    public $final_unit_price_tax_excluded = '';
    public $ctax_price = '';
    public $include_tax = '';
    public $exclude_tax = '';
    public $ctax_rate = '';
    public $quantity = '';
    public $subtotal_tax_included = '';
    public $subtotal_tax_excluded = '';
    public $avg_stocking_price = '';
    public $this_stock_quantity = '';

    public function render(ProductService $productService, StockService $stockService, TaxService $taxService)
    {
        $index = $this->index;
        if ($this->product_code) {
            $product_code = trim($this->product_code);
            $product = $productService->getByCode($product_code);
            $stock = null;
            if ($product !== null) {
                if ($this->product_id !== $product->id) {
                    $this->reset();
                }
                $this->index = $index;
                $this->product_id = $product->id;
                $this->product_code = $product_code;
                $this->name = $product !== null ? $product->name : '商品がみつかりません';
                $stock = $stockService->getThisStock($this->product_id);
            }
            if ($stock) {
                $this->avg_stocking_price = $stock->avg_stocking_price;
                $this->this_stock_quantity = $stock->this_stock_quantity;
                if ($this->unit_price == '') {
                    $this->quantity = 1;
                    if ($this->transaction_type == TransactionType::SALES) {
                        $this->unit_price = (integer)$stock->sell_price;
                        $this->tax_rate_type_id = $stock->sell_tax_rate_type_id;
                        $this->taxable_method_type_id = $stock->sell_taxable_method_type_id;
                    } else {
                        $this->unit_price = (integer)$stock->stocking_price;
                        $this->tax_rate_type_id = $stock->stocking_tax_rate_type_id;
                        $this->taxable_method_type_id = $stock->stocking_taxable_method_type_id;
                    }
                }
            }
            if (is_numeric($this->unit_price) && is_numeric($this->quantity)) {
                $taxable = $taxService->calcTax($this->unit_price, $this->tax_rate_type_id, $this->taxable_method_type_id);
                $this->final_unit_price_tax_included = $taxable['priceTaxIncluded'];
                $this->final_unit_price_tax_excluded = $taxable['priceTaxExcluded'];
                $this->ctax_price = $taxable['taxPrice'] * $this->quantity;
                $this->include_tax = $taxable['includeTax'] * $this->quantity;
                $this->exclude_tax = $taxable['excludeTax'] * $this->quantity;
                $this->ctax_rate = $taxable['taxRate'];
                $this->subtotal_tax_included = $this->final_unit_price_tax_included * $this->quantity;
                $this->subtotal_tax_excluded = $this->final_unit_price_tax_excluded * $this->quantity;
            }
        } else {
            $this->reset();
            $this->index = $index;
        }

        return view('livewire.product', [
            'i' => $this->index,
        ]);
    }
}
