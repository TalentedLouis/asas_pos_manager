<?php

namespace App\Http\Livewire;

use App\Enums\TransactionType;
use App\Models\Customer;
use App\Models\EntryExitTarget;
use App\Models\TransactionLine;
use App\Models\TransactionSlip;
use App\Services\ProductService;
use App\Services\StockService;
use App\Services\TaxService;
use App\Services\CustomerService;
use App\Services\SupplierTargetService;
use App\Services\EntryExitTargetService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Livewire\Component;

//2023add
/*
protected $listeners = [
    'changeProduct',
];
*/
//2023add

class Transactions extends Component
{
    public TransactionSlip $slip;
    public TransactionLine $line;
    public $transaction_type_id;
    /*
    public $product_code = [], $unit_price = [], $product_id = [],
        $product_name, $quantity, $avg_stocking_price, $this_stock_quantity,
        $tax_rate_type_id = [], $taxable_method_type_id = [],
        $final_unit_price_tax_included, $final_unit_price_tax_excluded,
        $ctax_price=[], $include_tax, $exclude_tax, $ctax_rate, $subtotal_tax_included, $subtotal_tax_excluded;
    */
    public  $product_code = [], 
            $unit_price = [], 
            $product_id,
            $product_name, 
            $quantity, 
            $avg_stocking_price, 
            $this_stock_quantity,
            $tax_rate_type_id = [], 
            $taxable_method_type_id = [],
            $final_unit_price_tax_included, 
            $final_unit_price_tax_excluded,
            $ctax_price=[], 
            $include_tax, 
            $exclude_tax, 
            $ctax_rate, 
            $subtotal_tax_included, 
            $subtotal_tax_excluded;

    public $lines = [];
    public $index = 0;
    //2023upd
    public $test_message;
    public $message;

    Public $total_quantity;
    Public $total_subtotal_tax_included;
    Public $total_include_tax;
    Public $total_exclude_tax;
    //2023upd
    public $transaction_lines;

    protected $listeners = [
        'changeProduct',
		'changeTarget',
        'transactionAdd'
    ];

    protected $rules = [
        'slip.staff_id' => 'required|integer',
        'slip.supplier_target_id' => 'integer',
        'slip.customer_id' => 'integer',
        'slip.entry_exit_target_id' => 'integer',
        'slip.target_code' => '',
        'slip.target_name' => '',
        'test_id' => '',
    ];

    public function mount()
    {
        $this->slip->transaction_type_id = $this->transaction_type_id;
        if ($this->transaction_type_id == TransactionType::EXIT_MONEY) {
            $this->add_money();
        } elseif ($this->transaction_type_id == TransactionType::ENTRY_MONEY) {
            $this->add_money();
        } else {
            $this->transactionAdd(5);
        }
        $this->message = '良かった';
    }

    public function transactionAdd($counts)
    {
        $index = count($this->lines);
        for ($i = 0; $i < $counts; $i++) {
            $this->lines[$index] = new TransactionLine();
            $this->quantity[$index] = '';
            $this->product_code[$index] = '';
            $index = $index + 1;
        }
    }

    public function add_money()
    {
            $this->lines[0] = new TransactionLine();
            $this->product_code[0] = '9999999999918';
    }

    public function del($k)
    {
        unset($this->lines[$k]);
    }

	public function changeTarget($value)
    {
        $customerService = App::make(CustomerService::class);
        $supplierTargetService = App::make(SupplierTargetService::class);
        $entryExitTargetService = App::make(EntryExitTargetService::class);
        if ($value !== '') {
            if ($this->transaction_type_id === TransactionType::SALES) {
                $target = $customerService->getByCode($value);
            } elseif ($this->transaction_type_id === TransactionType::PURCHASE) {
                $target = $supplierTargetService->getByCode($value);
            } elseif ($this->transaction_type_id === TransactionType::EXIT_STOCK) {
                $target = $entryExitTargetService->getByCode($value);
            } elseif ($this->transaction_type_id === TransactionType::ENTRY_STOCK) {
                $target = $entryExitTargetService->getByCode($value);
            } else {
                //$target = EntryExitTarget::find($value);
            }
            if (is_null($target)) {
                $this->slip->customer_id = null;
                $this->slip->supplier_target_id = null;
                $this->slip->entry_exit_target_id = null;
                $this->slip->target_name = null;
                $this->test_message = '相手先がみつかりません。';
                return null;
            }
            if ($this->transaction_type_id == TransactionType::SALES) {
                $this->slip->customer_id = $target->id;
            } elseif ($this->transaction_type_id == TransactionType::PURCHASE) {
                $this->slip->supplier_target_id = $target->id;
            } elseif ($this->transaction_type_id == TransactionType::EXIT_STOCK) {
                $this->slip->entry_exit_target_id = $target->id;
            } elseif ($this->transaction_type_id == TransactionType::ENTRY_STOCK) {
                $this->slip->entry_exit_target_id = $target->id;
            } else {
                //$this->transaction_slip->entry_exit_target_id = $target->id;
            }
            $this->slip->target_code = $target->code;
            $this->slip->target_name = $target->name;
        }
    }

    public function changeProduct($index, $value, ProductService $productService, StockService $stockService, TaxService $taxService)
    {
        $data = $this->product_code;
        $data[$index] = $value;
        
        $this->product_code = $data;
        $this->slip->transaction_type_id = $this->transaction_type_id;

        if ($value !== '') {
            $this->test_message = $index;
            $p_data = $productService->getByCode($value);
            if ($p_data !== null){
                $this->product_name[$index] = $p_data->name;
                $this->product_id[$index] = $p_data->id;
                $stock = null;
                $stock = $stockService->getThisStock($p_data->id);
                if ($stock !== null) {
                    $this->avg_stocking_price[$index] = $stock->avg_stocking_price;
                    $this->this_stock_quantity[$index] = $stock->this_stock_quantity;
                    if (array_key_exists($index, $this->unit_price) === false) {
                        $this->test_message = 'test1';
                        $this->quantity[$index] = 1;
                        if ($this->transaction_type_id == TransactionType::SALES) {
                            $this->unit_price[$index] = (integer)$stock->sell_price;
                            $this->tax_rate_type_id[$index] = $stock->sell_tax_rate_type_id;
                            $this->taxable_method_type_id[$index] = $stock->sell_taxable_method_type_id;
                        } else {
                            $this->unit_price[$index] = (integer)$stock->stocking_price;
                            $this->tax_rate_type_id[$index] = $stock->stocking_tax_rate_type_id;
                            $this->taxable_method_type_id[$index] = $stock->stocking_taxable_method_type_id;
                        }
                    } else {
                        if (isset($this->unit_price[$index]) === false) {
                            $this->test_message = 'test4';
                        }
                        if ($this->quantity[$index] > 0){
                            //$this->test_message = 'test2';
                            $this->quantity[$index] = 1;
                            if ($this->transaction_type_id == TransactionType::SALES) {
                                $this->unit_price[$index] = (integer)$stock->sell_price;
                                $this->tax_rate_type_id[$index] = $stock->sell_tax_rate_type_id;
                                $this->taxable_method_type_id[$index] = $stock->sell_taxable_method_type_id;
                            } else {
                                $this->unit_price[$index] = (integer)$stock->stocking_price;
                                $this->tax_rate_type_id[$index] = $stock->stocking_tax_rate_type_id;
                                $this->taxable_method_type_id[$index] = $stock->stocking_taxable_method_type_id;
                            }
                        } else {
                            //$this->test_message = 'test3';
                            $this->quantity[$index] = 1;
                            if ($this->transaction_type_id == TransactionType::SALES) {
                                $this->unit_price[$index] = (integer)$stock->sell_price;
                                $this->tax_rate_type_id[$index] = $stock->sell_tax_rate_type_id;
                                $this->taxable_method_type_id[$index] = $stock->sell_taxable_method_type_id;
                            } else {
                                $this->unit_price[$index] = (integer)$stock->stocking_price;
                                $this->tax_rate_type_id[$index] = $stock->stocking_tax_rate_type_id;
                                $this->taxable_method_type_id[$index] = $stock->stocking_taxable_method_type_id;
                            }
                        }
                    }     
                } 
                else {
                    $this->test_message = '商品の在庫データがみつかりません。商品登録して下さい。';
                    $this->product_name[$index] = '';
                    $this->quantity[$index] = '';
                    $this->avg_stocking_price[$index] = '';
                    $this->this_stock_quantity[$index] = '';
                    $this->unit_price[$index] = '';
                    $this->tax_rate_type_id[$index] = '';
                    $this->taxable_method_type_id[$index] = '';
                    $this->final_unit_price_tax_included[$index] = '';
                    $this->final_unit_price_tax_excluded[$index] = '';
                    $this->ctax_price[$index] = '';
                    $this->include_tax[$index] = '';
                    $this->exclude_tax[$index] = '';
                    $this->ctax_rate[$index] = '';
                    $this->subtotal_tax_included[$index] = '';
                    $this->subtotal_tax_excluded[$index] = '';
                }
            } else {
                $this->product_name[$index] = '';
                $this->quantity[$index] = '';
                $this->avg_stocking_price[$index] = '';
                $this->this_stock_quantity[$index] = '';
                $this->unit_price[$index] = '';
                $this->tax_rate_type_id[$index] = '';
                $this->taxable_method_type_id[$index] = '';
                $this->final_unit_price_tax_included[$index] = '';
                $this->final_unit_price_tax_excluded[$index] = '';
                $this->ctax_price[$index] = '';
                $this->include_tax[$index] = '';
                $this->exclude_tax[$index] = '';
                $this->ctax_rate[$index] = '';
                $this->subtotal_tax_included[$index] = '';
                $this->subtotal_tax_excluded[$index] = '';
                $this->test_message = '商品がみつかりません。商品登録お願い致します。';
            }
                                
            if (is_numeric($this->unit_price[$index]) && is_numeric($this->quantity[$index])) {
                $taxable = $taxService->calcTax($this->unit_price[$index], $this->tax_rate_type_id[$index], $this->taxable_method_type_id[$index]);
                $this->final_unit_price_tax_included[$index] = $taxable['priceTaxIncluded'];
                $this->final_unit_price_tax_excluded[$index] = $taxable['priceTaxExcluded'];
                $this->ctax_price[$index] = $taxable['taxPrice'] * $this->quantity[$index];
                $this->include_tax[$index] = $taxable['includeTax'] * $this->quantity[$index];
                $this->exclude_tax[$index] = $taxable['excludeTax'] * $this->quantity[$index];
                $this->ctax_rate[$index] = $taxable['taxRate'];
                $this->subtotal_tax_included[$index] = $this->final_unit_price_tax_included[$index] * $this->quantity[$index];
                $this->subtotal_tax_excluded[$index] = $this->final_unit_price_tax_excluded[$index] * $this->quantity[$index];
            }
        }

        $this->Totalcalc();
    }

    public function Totalcalc()
    {   
        $taxService = App::make(TaxService::class);
        $this->total_quantity = 0;
        $this->total_subtotal_tax_included = 0;
        $this->total_include_tax = 0;
        $this->total_exclude_tax = 0;
        $this->slip->transaction_type_id = $this->transaction_type_id;

        foreach ($this->lines as $index=>$line) {
            if (isset($this->unit_price[$index]) && isset($this->quantity[$index]) && is_numeric($this->unit_price[$index]) && is_numeric($this->quantity[$index])) {
                $taxable = $taxService->calcTax($this->unit_price[$index], $this->tax_rate_type_id[$index], $this->taxable_method_type_id[$index]);
                $this->final_unit_price_tax_included[$index] = $taxable['priceTaxIncluded'];
                $this->final_unit_price_tax_excluded[$index] = $taxable['priceTaxExcluded'];
                $this->ctax_price[$index] = $taxable['taxPrice'] * $this->quantity[$index];
                $this->include_tax[$index] = $taxable['includeTax'] * $this->quantity[$index];
                $this->exclude_tax[$index] = $taxable['excludeTax'] * $this->quantity[$index];
                $this->ctax_rate[$index] = $taxable['taxRate'];
                $this->subtotal_tax_included[$index] = $this->final_unit_price_tax_included[$index] * $this->quantity[$index];
                $this->subtotal_tax_excluded[$index] = $this->final_unit_price_tax_excluded[$index] * $this->quantity[$index];
            }

            if(isset($this->quantity[$index]) && is_numeric($this->quantity[$index]))
                $this->total_quantity += $this->quantity[$index];
            if(isset($this->subtotal_tax_included[$index]) && is_numeric($this->subtotal_tax_included[$index]))
                $this->total_subtotal_tax_included += $this->subtotal_tax_included[$index];
            if(isset($this->include_tax[$index]) && is_numeric($this->include_tax[$index]))
                $this->total_include_tax += $this->include_tax[$index];
            if(isset($this->exclude_tax[$index]) && is_numeric($this->exclude_tax[$index]))
                $this->total_exclude_tax += $this->exclude_tax[$index];
        }

    }

    public function render()
    {
        $this->slip->transaction_type_id = $this->transaction_type_id;
        $this->Totalcalc();
        return view('livewire.transactions');
    }
}
