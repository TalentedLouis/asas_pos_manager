<?php

namespace App\Http\Livewire;

use App\Enums\TransactionType;
use App\Models\Customer;
use App\Models\EntryExitTarget;
use App\Models\Staff;
use App\Models\Stock;
use App\Models\SupplierTarget;
use App\Models\TransactionSlip;
//2023 add
use App\Models\TransactionLine;
//2023 add
use App\Models\Product;
use App\Services\ProductService;
use App\Services\StockService;
use App\Services\TaxService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdateTransactions extends Component
{
    public $slipId;
    public $transaction_slip;
    public $transaction_lines;
    public $staff_message;
    public $target_message;
    //2023upd
    public $line_message;
    public $test_message = 'no message';
    //2023upd

    //2023add
    public $total_quantity;
    public $total_amount_ctax_included;
    //2023add
    protected $listeners = [
        'changeStaff',
        'changeTarget',
        'changeProduct',
        'changeQuantity',
        'changeUnitPrice',
    ];

    protected $rules = [
        'transaction_slip.staff_id' => 'required',
        'transaction_slip.staff_name' => 'required',
        'transaction_slip.customer_id' => 'required',
        'transaction_slip.supplier_target_id' => 'required',
        'transaction_slip.entry_exit_target_id' => 'required',
        'transaction_slip.target_name' => 'required',
        'transaction_lines.*.product_id' => '',
        'transaction_lines.*.product_code' => '',
        'transaction_lines.*.product_name' => '',
        'transaction_lines.*.quantity' => '',
        'transaction_lines.*.unit_price' => '',
        'transaction_lines.*.tax_rate_type_id' => '',
        'transaction_lines.*.taxable_method_type_id' => '',
        'transaction_lines.*.final_unit_price_tax_included' => '',
        'transaction_lines.*.final_unit_price_tax_excluded' => '',
        'transaction_lines.*.ctax_price' => '',
        'transaction_lines.*.include_tax' => '',
        'transaction_lines.*.exclude_tax' => '',
        'transaction_lines.*.ctax_rate' => '',
        'transaction_lines.*.subtotal_tax_included' => '',
        'transaction_lines.*.subtotal_tax_excluded' => '',
        'transaction_lines.*.avg_stocking_price' => '',
        'transaction_lines.*.this_stock_quantity' => '',
        // 2023 ADD S
        'transaction_slip.total_quantity' => '',
        'transaction_slip.total_amount_ctax_included' => '',
        // 2023 ADD E
    ];

    public function changeStaff($value)
    {
        $this->staff_message = '';
        if ($value !== '') {
            $staff = Staff::find($value);
            if (is_null($staff)) {
                $this->transaction_slip->staff_id = null;
                $this->transaction_slip->staff_name = null;
                $this->staff_message = '担当者がみつかりません。';
                return null;
            }
            $this->transaction_slip->staff_id = $staff->id;
            $this->transaction_slip->staff_name = $staff->name;
        }
    }

    public function changeTarget($value)
    {
        $this->target_message = '';
        if ($value !== '') {
            if ($this->transaction_slip->transaction_type_id === TransactionType::SALES) {
                $target = Customer::find($value);
            } elseif ($this->transaction_slip->transaction_type_id === TransactionType::PURCHASE) {
                $target = SupplierTarget::find($value);
            } elseif ($this->transaction_slip->transaction_type_id === TransactionType::EXIT_STOCK) {
                $target = EntryExitTarget::find($value);
            } elseif ($this->transaction_slip->transaction_type_id === TransactionType::ENTRY_STOCK) {
                $target = EntryExitTarget::find($value);
            } else {
                $target = EntryExitTarget::find($value);
            }
            if (is_null($target)) {
                $this->transaction_slip->customer_id = null;
                $this->transaction_slip->supplier_target_id = null;
                $this->transaction_slip->entry_exit_target_id = null;
                $this->transaction_slip->target_name = null;
                $this->target_message = '相手先がみつかりません。';
                return null;
            }
            if ($this->transaction_slip->transaction_type_id == TransactionType::SALES) {
                $this->transaction_slip->customer_id = $target->id;
            } elseif ($this->transaction_slip->transaction_type_id == TransactionType::PURCHASE) {
                $this->transaction_slip->supplier_target_id = $target->id;
            } elseif ($this->transaction_slip->transaction_type_id == TransactionType::EXIT_STOCK) {
                $this->transaction_slip->entry_exit_target_id = $target->id;
            } elseif ($this->transaction_slip->transaction_type_id == TransactionType::ENTRY_STOCK) {
                $this->transaction_slip->entry_exit_target_id = $target->id;
            } else {
                $this->transaction_slip->entry_exit_target_id = $target->id;
            }
            $this->transaction_slip->target_name = $target->name;
        }
    }

    public function changeProduct($index, $value)
    {
        //2023upd
        $this->line_message = null;
        //2023upd
        $productService = App::make(ProductService::class);
        $stockService = App::make(StockService::class);
        if ($value !== '') {
            $product = $productService->getByCode($value);
//            $product = Product::where('code', '=', $value)->first();
            $stock = null;
            if ($product !== null) {
                $this->transaction_lines[$index]->product_id = $product->id;
                $this->transaction_lines[$index]->product_name = $product->name;
                $stock = $stockService->getThisStock($product->id);
//                $stock = Stock::where('product_id', '=', $product->id)->where('shop_id', '=', Auth::user()->shop->id)->first();
                //2023add s
                if (!is_numeric($this->transaction_lines[$index]->quantity)){
                    $this->test_message = 'test';
                    $this->transaction_lines[$index]->quantity = 1;
                }
                //2023add e
            
            } else {
                //2023upd
                $this->transaction_lines[$index]->product_id = null;
                $this->transaction_lines[$index]->product_name = null;
                $this->transaction_lines[$index]->avg_stocking_price = null;
                $this->transaction_lines[$index]->this_stock_quantity = null;
                $this->transaction_lines[$index]->unit_price = null;
                $this->transaction_lines[$index]->quantity = null;
                $this->line_message = (integer)$index + 1 .'行目の商品コード：'.$value.' の商品が見つかりません。';
            //2023upd
            }
            
            if ($stock !== null) {
                $this->transaction_lines[$index]->avg_stocking_price = $stock->avg_stocking_price;
                $this->transaction_lines[$index]->this_stock_quantity = $stock->this_stock_quantity;
                if ($this->transaction_slip->transaction_type_id == TransactionType::SALES) {
                    $this->transaction_lines[$index]->unit_price = (integer)$stock->sell_price;
                    $this->transaction_lines[$index]->tax_rate_type_id = $stock->sell_tax_rate_type_id;
                    $this->transaction_lines[$index]->taxable_method_type_id = $stock->sell_taxable_method_type_id;
                } else {
                    $this->transaction_lines[$index]->unit_price = (integer)$stock->stocking_price;
                    $this->transaction_lines[$index]->tax_rate_type_id = $stock->stocking_tax_rate_type_id;
                    $this->transaction_lines[$index]->taxable_method_type_id = $stock->stocking_taxable_method_type_id;
                }
            }
            // Calc tax, subTotal...
            $this->calcTax($index);
        } else {
            // TODO Clear line
        }
    }

    public function changeQuantity($index, $value)
    {
        if ($value !== '') {
            $this->transaction_lines[$index]->quantity = $value;
            // Calc tax, subTotal...
            $this->calcTax($index);
        }
    }

    public function changeUnitPrice($index, $value)
    {
        if ($value !== '') {
            $this->transaction_lines[$index]->unit_price = $value;
            // Calc tax, subTotal...
            $this->calcTax($index);
        }
    }

    public function del($index)
    {
        $this->transaction_lines[$index]->product_id = null;
        $this->transaction_lines[$index]->product_code = null;
        $this->transaction_lines[$index]->product_name = null;
        $this->transaction_lines[$index]->avg_stocking_price = null;
        $this->transaction_lines[$index]->this_stock_quantity = null;
        $this->transaction_lines[$index]->unit_price = null;
        $this->transaction_lines[$index]->quantity = null;
        $this->transaction_lines[$index]->tax_rate_type_id = null;
        $this->transaction_lines[$index]->taxable_method_type_id = null;
        $this->transaction_lines[$index]->final_unit_price_tax_included = null;
        $this->transaction_lines[$index]->final_unit_price_tax_excluded = null;
        $this->transaction_lines[$index]->ctax_price = null;
        $this->transaction_lines[$index]->include_tax = null;
        $this->transaction_lines[$index]->exclude_tax = null;
        $this->transaction_lines[$index]->ctax_rate = null;
        $this->transaction_lines[$index]->subtotal_tax_included = null;
        $this->transaction_lines[$index]->subtotal_tax_excluded = null;
        $this->Totalcalc();
        //$index = $index - 1;
        //$this->index = $index;
    }

    public function calcTax($index)
    {
        $taxService = App::make(TaxService::class);
        if (is_numeric($this->transaction_lines[$index]->unit_price) && is_numeric($this->transaction_lines[$index]->quantity)) {
            $taxable = $taxService->calcTax(
                $this->transaction_lines[$index]->unit_price,
                $this->transaction_lines[$index]->tax_rate_type_id,
                $this->transaction_lines[$index]->taxable_method_type_id
            );
            $this->transaction_lines[$index]->final_unit_price_tax_included = $taxable['priceTaxIncluded'];
            $this->transaction_lines[$index]->final_unit_price_tax_excluded = $taxable['priceTaxExcluded'];
            $this->transaction_lines[$index]->ctax_price =
                $taxable['taxPrice'] * $this->transaction_lines[$index]->quantity;
            $this->transaction_lines[$index]->include_tax =
                $taxable['includeTax'] * $this->transaction_lines[$index]->quantity;
            $this->transaction_lines[$index]->exclude_tax =
                $taxable['excludeTax'] * $this->transaction_lines[$index]->quantity;
            $this->transaction_lines[$index]->ctax_rate = $taxable['taxRate'];
            $this->transaction_lines[$index]->subtotal_tax_included =
                $this->transaction_lines[$index]->final_unit_price_tax_included * $this->transaction_lines[$index]->quantity;
            $this->transaction_lines[$index]->subtotal_tax_excluded =
                $this->transaction_lines[$index]->final_unit_price_tax_excluded * $this->transaction_lines[$index]->quantity;
        } else {
            $this->transaction_lines[$index]->unit_price = null;
            $this->transaction_lines[$index]->tax_rate_type_id = null;
            $this->transaction_lines[$index]->taxable_method_type_id = null;
            $this->transaction_lines[$index]->final_unit_price_tax_included = null;
            $this->transaction_lines[$index]->final_unit_price_tax_excluded = null;
            $this->transaction_lines[$index]->ctax_price = null;
            $this->transaction_lines[$index]->include_tax = null;
            $this->transaction_lines[$index]->exclude_tax = null;
            $this->transaction_lines[$index]->ctax_rate = null;
            $this->transaction_lines[$index]->subtotal_tax_included = null;
            $this->transaction_lines[$index]->subtotal_tax_excluded = null;
        }
        //　2023 add s
        $this->Totalcalc();
        //　2023 add e
    }

    public function Totalcalc()
    {     
        $this->total_quantity = 0;
        $this->total_amount_ctax_included = 0;
        foreach ($this->transaction_lines as $key => $transaction_lines) {
            $this->total_quantity += $this->transaction_lines[$key]->quantity;
            $this->total_amount_ctax_included += $this->transaction_lines[$key]->subtotal_tax_included;
        }
        $this->transaction_slip->total_quantity = $this->total_quantity;
        $this->transaction_slip->total_amount_ctax_included = $this->total_amount_ctax_included;
    }

    public function add($index, $counts = 1)
    {
        for ($i = 0; $i < $counts; $i++) {
            $this->transaction_lines[$index] = new TransactionLine();
            //$index = $index + 1;
            //$this->index = $index;
        }
    }

    public function mount()
    {
        $this->transaction_slip = TransactionSlip::findOrFail($this->slipId);
        $this->transaction_lines = $this->transaction_slip->transaction_lines;
        $this->changeStaff($this->transaction_slip->staff_id);
        if ($this->transaction_slip->transaction_type_id === TransactionType::SALES) {
            $this->changeTarget($this->transaction_slip->customer_id);
        } elseif ($this->transaction_slip->transaction_type_id === TransactionType::PURCHASE) {
            $this->changeTarget($this->transaction_slip->supplier_target_id);
        } else {
            $this->changeTarget($this->transaction_slip->entry_exit_target_id);
        }
        //add(50,3);
    }

    public function render()
    {
        return view('livewire.update-transactions');
    }
}
