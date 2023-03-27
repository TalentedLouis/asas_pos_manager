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
    public $product_code = [], $unit_price = [], $product_id,
        $product_name, $quantity, $avg_stocking_price, $this_stock_quantity,
        $tax_rate_type_id = [], $taxable_method_type_id = [],
        $final_unit_price_tax_included, $final_unit_price_tax_excluded,
        $ctax_price=[], $include_tax, $exclude_tax, $ctax_rate, $subtotal_tax_included, $subtotal_tax_excluded;

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
    ];

    public function mount()
    {
        $this->slip->transaction_type_id = $this->transaction_type_id;
        $this->add($this->index, 30);
        $this->message = '良かった';
    }

    protected $rules = [
        'slip.staff_id' => 'required|integer',
        'slip.supplier_target_id' => 'integer',
        'slip.customer_id' => 'integer',
        'slip.entry_exit_target_id' => 'integer',
        'slip.target_code' => '',
        'slip.target_name' => '',
        'test_id' => '',
    ];

    public function add($index, $counts = 1)
    {
        for ($i = 0; $i < $counts; $i++) {
            $this->lines[$index] = new TransactionLine();
            $this->quantity[$index] = '';
            //$this->unit_price[$index] = '';
            $index = $index + 1;
            $this->index = $index;
            
        }
        //$this->test_message = $index ;   
    }

    public function del($index,$k)
    {
        unset($this->lines[$k]);
        $index = $index - 1;
        $this->index = $index;
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
    public function changeProduct($index, $value)
    {
        $data = $this->product_code;
        if(count($data) > $index){
            $data[$index] = $value;
        } else {
            array_push($data, $value);
        }
        $this->product_code = $data;
    }

    public function render(ProductService $productService, StockService $stockService, TaxService $taxService)
    {
        $this->test_message = '';
        $this->total_quantity = 0;
        $this->total_subtotal_tax_included = 0;
        $this->total_include_tax = 0;
        $this->total_exclude_tax = 0;
        $this->slip->transaction_type_id = $this->transaction_type_id;
        if (count($this->product_code) > 0) {
            foreach ($this->lines as $key => $line_test) {
                if (array_key_exists($key, $this->product_code)) {
                    $this->test_message = $key;
                    $p_code = $this->product_code[$key];
                    $p_data = $productService->getByCode($p_code);
                    if ($p_data !== null){
                        $this->product_name[$key] = $p_data->name;
                        $this->product_id[$key] = $p_data->id;
                        $stock = null;
                        $stock = $stockService->getThisStock($p_data->id);
                        if ($stock !== null) {
                            $this->avg_stocking_price[$key] = $stock->avg_stocking_price;
                            $this->this_stock_quantity[$key] = $stock->this_stock_quantity;
                            if (array_key_exists($key, $this->unit_price) === false) {
                                $this->test_message = 'test1';
                                $this->quantity[$key] = 1;
                                if ($this->transaction_type_id == TransactionType::SALES) {
                                    $this->unit_price[$key] = (integer)$stock->sell_price;
                                    $this->tax_rate_type_id[$key] = $stock->sell_tax_rate_type_id;
                                    $this->taxable_method_type_id[$key] = $stock->sell_taxable_method_type_id;
                                } else {
                                    $this->unit_price[$key] = (integer)$stock->stocking_price;
                                    $this->tax_rate_type_id[$key] = $stock->stocking_tax_rate_type_id;
                                    $this->taxable_method_type_id[$key] = $stock->stocking_taxable_method_type_id;
                                }
                            } else {
                                if (isset($this->unit_price[$key]) === false) {
                                    $this->test_message = 'test4';
                                }


                                if ($this->quantity[$key] > 0){
                                    //$this->test_message = 'test2';
                                    $this->quantity[$key] = 1;
                                    if ($this->transaction_type_id == TransactionType::SALES) {
                                        $this->unit_price[$key] = (integer)$stock->sell_price;
                                        $this->tax_rate_type_id[$key] = $stock->sell_tax_rate_type_id;
                                        $this->taxable_method_type_id[$key] = $stock->sell_taxable_method_type_id;
                                    } else {
                                        $this->unit_price[$key] = (integer)$stock->stocking_price;
                                        $this->tax_rate_type_id[$key] = $stock->stocking_tax_rate_type_id;
                                        $this->taxable_method_type_id[$key] = $stock->stocking_taxable_method_type_id;
                                    }
                                } else {
                                    //$this->test_message = 'test3';
                                    $this->quantity[$key] = 1;
                                    if ($this->transaction_type_id == TransactionType::SALES) {
                                        $this->unit_price[$key] = (integer)$stock->sell_price;
                                        $this->tax_rate_type_id[$key] = $stock->sell_tax_rate_type_id;
                                        $this->taxable_method_type_id[$key] = $stock->sell_taxable_method_type_id;
                                    } else {
                                        $this->unit_price[$key] = (integer)$stock->stocking_price;
                                        $this->tax_rate_type_id[$key] = $stock->stocking_tax_rate_type_id;
                                        $this->taxable_method_type_id[$key] = $stock->stocking_taxable_method_type_id;
                                    }
                                }
                            }
                                
                        } else {
                            $this->test_message = '商品の在庫データがみつかりません。商品登録して下さい。';
                            $this->product_name[$key] = '';
                            $this->quantity[$key] = '';
                            $this->avg_stocking_price[$key] = '';
                            $this->this_stock_quantity[$key] = '';
                            $this->unit_price[$key] = '';
                            $this->tax_rate_type_id[$key] = '';
                            $this->taxable_method_type_id[$key] = '';
                            $this->final_unit_price_tax_included[$key] = '';
                            $this->final_unit_price_tax_excluded[$key] = '';
                            $this->ctax_price[$key] = '';
                            $this->include_tax[$key] = '';
                            $this->exclude_tax[$key] = '';
                            $this->ctax_rate[$key] = '';
                            $this->subtotal_tax_included[$key] = '';
                            $this->subtotal_tax_excluded[$key] = '';
                        }
                    
                    } else {
                        $this->product_name[$key] = '';
                        $this->quantity[$key] = '';
                        $this->avg_stocking_price[$key] = '';
                        $this->this_stock_quantity[$key] = '';
                        $this->unit_price[$key] = '';
                        $this->tax_rate_type_id[$key] = '';
                        $this->taxable_method_type_id[$key] = '';
                        $this->final_unit_price_tax_included[$key] = '';
                        $this->final_unit_price_tax_excluded[$key] = '';
                        $this->ctax_price[$key] = '';
                        $this->include_tax[$key] = '';
                        $this->exclude_tax[$key] = '';
                        $this->ctax_rate[$key] = '';
                        $this->subtotal_tax_included[$key] = '';
                        $this->subtotal_tax_excluded[$key] = '';
                        $this->test_message = '商品がみつかりません。商品登録お願い致します。';
                    }

                    
                    if (is_numeric($this->unit_price[$key]) && is_numeric($this->quantity[$key])) {
                        $taxable = $taxService->calcTax($this->unit_price[$key], $this->tax_rate_type_id[$key], $this->taxable_method_type_id[$key]);
                        $this->final_unit_price_tax_included[$key] = $taxable['priceTaxIncluded'];
                        $this->final_unit_price_tax_excluded[$key] = $taxable['priceTaxExcluded'];
                        $this->ctax_price[$key] = $taxable['taxPrice'] * $this->quantity[$key];
                        $this->include_tax[$key] = $taxable['includeTax'] * $this->quantity[$key];
                        $this->exclude_tax[$key] = $taxable['excludeTax'] * $this->quantity[$key];
                        $this->ctax_rate[$key] = $taxable['taxRate'];
                        $this->subtotal_tax_included[$key] = $this->final_unit_price_tax_included[$key] * $this->quantity[$key];
                        $this->subtotal_tax_excluded[$key] = $this->final_unit_price_tax_excluded[$key] * $this->quantity[$key];

                        $this->total_quantity += $this->quantity[$key];
                        $this->total_subtotal_tax_included += $this->subtotal_tax_included[$key];
                        $this->total_include_tax += $this->include_tax[$key];
                        $this->total_exclude_tax += $this->exclude_tax[$key];
                    }
                    
                }
            }

        } else {
            foreach ($this->lines as $key => $line) {
                //$this->quantity[$key] = '';
                //$this->unit_price[$key] = '';
            }
            // TODO livewire reset
        }
        $line_message = 'chk' ;
        return view('livewire.transactions');
    }
}
