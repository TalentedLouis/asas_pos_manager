<?php

namespace App\UseCases;

use App\Enums\PaymentMethodType;
use App\Enums\TaxableMethodType;
use App\Enums\TransactionType;
use App\Models\TransactionLine;
use App\Models\TransactionSlip;
use App\Repositories\StockRepositoryInterface;
use App\Repositories\TransactionLineRepositoryInterface;
use App\Repositories\TransactionSlipRepositoryInterface;
use App\Services\TransactionSlipService;
use App\UseCases\ShopConfigActions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\ExitStockRequest;
use App\Http\Requests\EntryStockRequest;
use App\Http\Requests\ExitMoneyRequest;
use App\Http\Requests\EntryMoneyRequest;

class TransactionActions
{
    private TransactionSlipRepositoryInterface $slipRepository;
    private TransactionLineRepositoryInterface $lineRepository;
    private TransactionSlipService $slipService;
    private StockRepositoryInterface $stockRepository;
    private ShopConfigActions $shopConfigAction;

    public function __construct(
        TransactionSlipRepositoryInterface $slipRepository,
        TransactionLineRepositoryInterface $lineRepository,
        TransactionSlipService             $slipService,
        StockRepositoryInterface           $stockRepository,
        ShopConfigActions                  $shopConfigAction
    )
    {
        $this->slipRepository = $slipRepository;
        $this->lineRepository = $lineRepository;
        $this->slipService = $slipService;
        $this->stockRepository = $stockRepository;
        $this->shopConfigAction = $shopConfigAction;

    }

    /**
     * @return LengthAwarePaginator
     */
    public function getByDate($fromDate = null, $toDate = null, $transaction_type_id): LengthAwarePaginator
    {
        if (is_null($fromDate)) {
            $fromDate = Date::now()->format(config('app.date_format'));
        }
        if (is_null($toDate)) {
            $toDate = Date::now()->format(config('app.date_format'));
        }
        return $this->slipRepository->findByDate($fromDate, $toDate, $transaction_type_id);
    }

    public function create_purchase(PurchaseRequest $post)
    {
        $slip = $this->slipRepository->newEntity();
        $slipNumber = $this->slipService->newSlipNumber();
        // Make slip...
        $slip->shop_id = Auth::user()->shop->id;
        $trans_date = $this->shopConfigAction->get_trans_date();
        
        $slip->slip_no = $slipNumber;
        $slip->staff_id = $post['staff_id'];
        //$slip->transacted_on = Date::now()->format(config('app.date_format'));
        $slip->transacted_on = $trans_date;
        $slip->transaction_type_id = $post->transaction_type_id;
        $slip->target_code = $post->has('target_code') ? $post->target_code : null;
        $slip->customer_id = $post->has('customer_id') ? $post->customer_id : null;
        $slip->supplier_target_id = $post->has('supplier_target_id') ? $post->supplier_target_id : null;
        $slip->entry_exit_target_id = $post->has('entry_exit_target_id') ? $post->entry_exit_target_id : null;
        $slip->payment_method_id = $post->has('payment_method_id') ? $post->payment_method_id : PaymentMethodType::CASH;
        $slip->cash_deposit_amount = $post->has('cash_deposit_amount') ? $post->cash_deposit_amount : null;
        $slip->cash_payout_amount = $post->has('cash_payout_amount') ? $post->cash_payout_amount : null;
        $slip->qr_sequence_id = $post->has('qr_sequence_id') ? $post->qr_sequence_id : null;
        $slip->qr_service_name = $post->has('qr_service_name') ? $post->qr_service_name : null;
        $slip->qr_slip_number = $post->has('qr_slip_number') ? $post->qr_slip_number : null;
        $slip->qr_trunsaction_number = $post->has('qr_trunsaction_number') ? $post->qr_trunsaction_number : null;
        $slip->credit_sequence_id = $post->has('credit_sequence_id') ? $post->credit_sequence_id : null;
        $slip->credit_service_name = $post->has('credit_service_name') ? $post->credit_service_name : null;
        $slip->credit_approval_number = $post->has('credit_approval_number') ? $post->credit_approval_number : null;
        $slip->credit_company_id = $post->has('credit_company_id') ? $post->credit_company_id : null;
        $slip->credit_condition_id = $post->has('credit_condition_id') ? $post->credit_condition_id : null;
        $slip->credit_slip_number = $post->has('credit_slip_number') ? $post->credit_slip_number : null;
        $slip->credit_trunsaction_number = $post->has('credit_trunsaction_number') ? $post->credit_trunsaction_number : null;
        $slip->ic_sequence_id = $post->has('ic_sequence_id') ? $post->ic_sequence_id : null;
        $slip->ic_service_name = $post->has('ic_service_name') ? $post->ic_service_name : null;
        $slip->ic_balance = $post->has('ic_balance') ? $post->ic_balance : null;
        $slip->ic_condition_id = $post->has('ic_condition_id') ? $post->ic_condition_id : null;
        $slip->ic_sprw_id = $post->has('ic_sprw_id') ? $post->ic_sprw_id : null;
        $slip->ic_trunsaction_number = $post->has('ic_trunsaction_number') ? $post->ic_trunsaction_number : null;
        $slip->ic_approval_number = $post->has('ic_approval_number') ? $post->ic_approval_number : null;
        $slip->ic_slip_number = $post->has('ic_slip_number') ? $post->ic_slip_number : null;
        $slip->ic_before_balance = $post->has('ic_before_balance') ? $post->ic_before_balance : null;
        $slip->is_refund = $post->has('is_refund') ? $post->is_refund : 0;
        $slip->refund_name = $post->has('refund_name') ? $post->refund_name : null;
        $slip->is_training = $post->has('is_training') ? $post->is_training : 0;
        $this->slipRepository->save($slip);
        // Make lines..
        $totalQuantity = 0;
        $totalAmountCtaxIncluded = 0;
        $totalAmountCtaxExcluded = 0;
        $totalAmountCtax = 0;
        $totalAmountCtax1Included = 0;
        $totalAmountCtax1 = 0;
        $totalAmountCtax2Included = 0;
        $totalAmountCtax2 = 0;
        $totalAmountCtax3Included = 0;
        $totalDiscountPrice = 0;
        foreach ($post->lines as $line_no => $postLine) {
            if ($postLine['product_id'] === null) {
                continue;
            }
            $line = $this->lineRepository->newEntity();
            $line->transaction_slip_id = $slip->id;
            $line->shop_id = Auth::user()->shop->id;//20230406 add
            //$line->transacted_on = Date::now()->format(config('app.date_format'));//20230406 add
            $line->transacted_on = $trans_date;
            $line->transaction_type_id = $post->transaction_type_id; //20230406 add
            $line->category_id = $postLine['category_id']; //20230406 add
            $line->genre_id = $postLine['genre_id']; //20230406 add
            $line->line_number = $line_no + 1;
            $line->product_id = $postLine['product_id'];
            $line->product_code = $postLine['product_code'];
            $line->product_name = $postLine['product_name'];
            $line->avg_stocking_price = array_key_exists('avg_stocking_price', $postLine) ? $postLine['avg_stocking_price'] : 0;
            $line->this_stock_quantity = array_key_exists('this_stock_quantity', $postLine) ? $postLine['this_stock_quantity'] : 0;
            $line->exclude_tax = array_key_exists('exclude_tax', $postLine) ? $postLine['exclude_tax'] : 0;
            $line->include_tax = array_key_exists('include_tax', $postLine) ? $postLine['include_tax'] : 0;
            $line->quantity = array_key_exists('quantity', $postLine) ? $postLine['quantity'] : 0;
            $totalQuantity += $line->quantity;
            $line->unit_price = array_key_exists('unit_price', $postLine) ? $postLine['unit_price'] : 0;
            $line->tax_rate_type_id = array_key_exists('tax_rate_type_id', $postLine) ? $postLine['tax_rate_type_id'] : 0;
            $line->taxable_method_type_id = array_key_exists('taxable_method_type_id', $postLine) ? $postLine['taxable_method_type_id'] : 0;
            $line->final_unit_price_tax_included = array_key_exists('final_unit_price_tax_included', $postLine) ? $postLine['final_unit_price_tax_included'] : 0;
            $line->final_unit_price_tax_excluded = array_key_exists('final_unit_price_tax_excluded', $postLine) ? $postLine['final_unit_price_tax_excluded'] : 0;
            $line->subtotal_tax_included = array_key_exists('subtotal_tax_included', $postLine) ? $postLine['subtotal_tax_included'] : 0;
            $totalAmountCtaxIncluded += $line->subtotal_tax_included;
            $line->subtotal_tax_excluded = array_key_exists('subtotal_tax_excluded', $postLine) ? $postLine['subtotal_tax_excluded'] : 0;
            $totalAmountCtaxExcluded += $line->subtotal_tax_excluded;
            $line->ctax_price = array_key_exists('ctax_price', $postLine) ? $postLine['ctax_price'] : 0;
            $totalAmountCtax += $line->ctax_price;
            if ($line->taxable_method_type_id == TaxableMethodType::STANDARD_TAX) {
                $totalAmountCtax1Included += $line->subtotal_tax_included;
                $totalAmountCtax1 += $line->ctax_price;
            } elseif ($line->taxable_method_type_id == TaxableMethodType::REDUCED_TAX) {
                $totalAmountCtax2Included += $line->subtotal_tax_included;
                $totalAmountCtax2 += $line->ctax_price;
            } else {
                $totalAmountCtax3Included += $line->subtotal_tax_included;
            }
            $line->ctax_rate = array_key_exists('ctax_rate', $postLine) ? $postLine['ctax_rate'] : 0;
            $line->discount_price = array_key_exists('discount_price', $postLine) ? $postLine['discount_price'] : 0;
            $totalDiscountPrice += $line->discount_price;
            $this->lineRepository->save($line);
        }
        $slip->total_quantity = $totalQuantity;
        $slip->total_cost = $post->has('total_cost') ? $post->total_cost : 0;
        $slip->total_amount_ctax_included = $totalAmountCtaxIncluded;
        $slip->total_amount_ctax_excluded = $totalAmountCtaxExcluded;
        $slip->total_amount_ctax = $totalAmountCtax;
        $slip->total_amount_ctax1_included = $totalAmountCtax1Included;
        $slip->total_amount_ctax1 = $totalAmountCtax1;
        $slip->total_amount_ctax2_included = $totalAmountCtax2Included;
        $slip->total_amount_ctax2 = $totalAmountCtax2;
        $slip->total_amount_ctax3_included = $totalAmountCtax3Included;
        $slip->total_discount_price = $totalDiscountPrice;
        $slip->total_payment_amount = $totalAmountCtaxIncluded;
        $this->slipRepository->save($slip);
        // Change Stocks
        $this->stockRepository->changeStock($slip);
    }

    public function create_sale(SaleRequest $post)
    {
        $slip = $this->slipRepository->newEntity();
        $slipNumber = $this->slipService->newSlipNumber();
        // Make slip...
        $slip->shop_id = Auth::user()->shop->id;
        $trans_date = $this->shopConfigAction->get_trans_date();
        
        $slip->slip_no = $slipNumber;
        $slip->staff_id = $post['staff_id'];
        //$slip->transacted_on = Date::now()->format(config('app.date_format'));
        $slip->transacted_on = $trans_date;
        $slip->transaction_type_id = $post->transaction_type_id;
        $slip->customer_id = $post->has('customer_id') ? $post->customer_id : null;
        $slip->target_code = $post->has('target_code') ? $post->target_code : null;
        $slip->supplier_target_id = $post->has('supplier_target_id') ? $post->supplier_target_id : null;
        $slip->entry_exit_target_id = $post->has('entry_exit_target_id') ? $post->entry_exit_target_id : null;
        $slip->payment_method_id = $post->has('payment_method_id') ? $post->payment_method_id : PaymentMethodType::CASH;
        $slip->cash_deposit_amount = $post->has('cash_deposit_amount') ? $post->cash_deposit_amount : null;
        $slip->cash_payout_amount = $post->has('cash_payout_amount') ? $post->cash_payout_amount : null;
        $slip->qr_sequence_id = $post->has('qr_sequence_id') ? $post->qr_sequence_id : null;
        $slip->qr_service_name = $post->has('qr_service_name') ? $post->qr_service_name : null;
        $slip->qr_slip_number = $post->has('qr_slip_number') ? $post->qr_slip_number : null;
        $slip->qr_trunsaction_number = $post->has('qr_trunsaction_number') ? $post->qr_trunsaction_number : null;
        $slip->credit_sequence_id = $post->has('credit_sequence_id') ? $post->credit_sequence_id : null;
        $slip->credit_service_name = $post->has('credit_service_name') ? $post->credit_service_name : null;
        $slip->credit_approval_number = $post->has('credit_approval_number') ? $post->credit_approval_number : null;
        $slip->credit_company_id = $post->has('credit_company_id') ? $post->credit_company_id : null;
        $slip->credit_condition_id = $post->has('credit_condition_id') ? $post->credit_condition_id : null;
        $slip->credit_slip_number = $post->has('credit_slip_number') ? $post->credit_slip_number : null;
        $slip->credit_trunsaction_number = $post->has('credit_trunsaction_number') ? $post->credit_trunsaction_number : null;
        $slip->ic_sequence_id = $post->has('ic_sequence_id') ? $post->ic_sequence_id : null;
        $slip->ic_service_name = $post->has('ic_service_name') ? $post->ic_service_name : null;
        $slip->ic_balance = $post->has('ic_balance') ? $post->ic_balance : null;
        $slip->ic_condition_id = $post->has('ic_condition_id') ? $post->ic_condition_id : null;
        $slip->ic_sprw_id = $post->has('ic_sprw_id') ? $post->ic_sprw_id : null;
        $slip->ic_trunsaction_number = $post->has('ic_trunsaction_number') ? $post->ic_trunsaction_number : null;
        $slip->ic_approval_number = $post->has('ic_approval_number') ? $post->ic_approval_number : null;
        $slip->ic_slip_number = $post->has('ic_slip_number') ? $post->ic_slip_number : null;
        $slip->ic_before_balance = $post->has('ic_before_balance') ? $post->ic_before_balance : null;
        $slip->is_refund = $post->has('is_refund') ? $post->is_refund : 0;
        $slip->refund_name = $post->has('refund_name') ? $post->refund_name : null;
        $slip->is_training = $post->has('is_training') ? $post->is_training : 0;
        $this->slipRepository->save($slip);
        // Make lines..
        $totalQuantity = 0;
        $totalAmountCtaxIncluded = 0;
        $totalAmountCtaxExcluded = 0;
        $totalAmountCtax = 0;
        $totalAmountCtax1Included = 0;
        $totalAmountCtax1 = 0;
        $totalAmountCtax2Included = 0;
        $totalAmountCtax2 = 0;
        $totalAmountCtax3Included = 0;
        $totalDiscountPrice = 0;
        foreach ($post->lines as $line_no => $postLine) {
            if ($postLine['product_id'] === null) {
                continue;
            }
            $line = $this->lineRepository->newEntity();
            $line->transaction_slip_id = $slip->id;
            $line->shop_id = Auth::user()->shop->id;//20230406 add
            $line->transacted_on = $trans_date;
            $line->transaction_type_id = $post->transaction_type_id; //20230406 add
            $line->category_id = $postLine['category_id']; //20230406 add
            $line->genre_id = $postLine['genre_id']; //20230406 add
            $line->line_number = $line_no + 1;
            $line->line_number = $line_no + 1;
            $line->product_id = $postLine['product_id'];
            $line->product_code = $postLine['product_code'];
            $line->product_name = $postLine['product_name'];
            $line->avg_stocking_price = array_key_exists('avg_stocking_price', $postLine) ? $postLine['avg_stocking_price'] : 0;
            $line->this_stock_quantity = array_key_exists('this_stock_quantity', $postLine) ? $postLine['this_stock_quantity'] : 0;
            $line->exclude_tax = array_key_exists('exclude_tax', $postLine) ? $postLine['exclude_tax'] : 0;
            $line->include_tax = array_key_exists('include_tax', $postLine) ? $postLine['include_tax'] : 0;
            $line->quantity = array_key_exists('quantity', $postLine) ? $postLine['quantity'] : 0;
            $totalQuantity += $line->quantity;
            $line->unit_price = array_key_exists('unit_price', $postLine) ? $postLine['unit_price'] : 0;
            $line->tax_rate_type_id = array_key_exists('tax_rate_type_id', $postLine) ? $postLine['tax_rate_type_id'] : 0;
            $line->taxable_method_type_id = array_key_exists('taxable_method_type_id', $postLine) ? $postLine['taxable_method_type_id'] : 0;
            $line->final_unit_price_tax_included = array_key_exists('final_unit_price_tax_included', $postLine) ? $postLine['final_unit_price_tax_included'] : 0;
            $line->final_unit_price_tax_excluded = array_key_exists('final_unit_price_tax_excluded', $postLine) ? $postLine['final_unit_price_tax_excluded'] : 0;
            $line->subtotal_tax_included = array_key_exists('subtotal_tax_included', $postLine) ? $postLine['subtotal_tax_included'] : 0;
            $totalAmountCtaxIncluded += $line->subtotal_tax_included;
            $line->subtotal_tax_excluded = array_key_exists('subtotal_tax_excluded', $postLine) ? $postLine['subtotal_tax_excluded'] : 0;
            $totalAmountCtaxExcluded += $line->subtotal_tax_excluded;
            $line->ctax_price = array_key_exists('ctax_price', $postLine) ? $postLine['ctax_price'] : 0;
            $totalAmountCtax += $line->ctax_price;
            if ($line->taxable_method_type_id == TaxableMethodType::STANDARD_TAX) {
                $totalAmountCtax1Included += $line->subtotal_tax_included;
                $totalAmountCtax1 += $line->ctax_price;
            } elseif ($line->taxable_method_type_id == TaxableMethodType::REDUCED_TAX) {
                $totalAmountCtax2Included += $line->subtotal_tax_included;
                $totalAmountCtax2 += $line->ctax_price;
            } else {
                $totalAmountCtax3Included += $line->subtotal_tax_included;
            }
            $line->ctax_rate = array_key_exists('ctax_rate', $postLine) ? $postLine['ctax_rate'] : 0;
            $line->discount_price = array_key_exists('discount_price', $postLine) ? $postLine['discount_price'] : 0;
            $totalDiscountPrice += $line->discount_price;
            $this->lineRepository->save($line);
        }
        $slip->total_quantity = $totalQuantity;
        $slip->total_cost = $post->has('total_cost') ? $post->total_cost : 0;
        $slip->total_amount_ctax_included = $totalAmountCtaxIncluded;
        $slip->total_amount_ctax_excluded = $totalAmountCtaxExcluded;
        $slip->total_amount_ctax = $totalAmountCtax;
        $slip->total_amount_ctax1_included = $totalAmountCtax1Included;
        $slip->total_amount_ctax1 = $totalAmountCtax1;
        $slip->total_amount_ctax2_included = $totalAmountCtax2Included;
        $slip->total_amount_ctax2 = $totalAmountCtax2;
        $slip->total_amount_ctax3_included = $totalAmountCtax3Included;
        $slip->total_discount_price = $totalDiscountPrice;
        $slip->total_payment_amount = $totalAmountCtaxIncluded;
        $this->slipRepository->save($slip);
        // Change Stocks
        $this->stockRepository->changeStock($slip);
    }

    public function create_entry(EntryStockRequest $post)
    {
        $slip = $this->slipRepository->newEntity();
        $slipNumber = $this->slipService->newSlipNumber();
        // Make slip...
        $slip->shop_id = Auth::user()->shop->id;
        $trans_date = $this->shopConfigAction->get_trans_date();
        
        $slip->slip_no = $slipNumber;
        $slip->staff_id = $post['staff_id'];
        $slip->transacted_on = $trans_date;
        $slip->transaction_type_id = $post->transaction_type_id;
        $slip->customer_id = $post->has('customer_id') ? $post->customer_id : null;
        $slip->supplier_target_id = $post->has('supplier_target_id') ? $post->supplier_target_id : null;
        $slip->entry_exit_target_id = $post->has('entry_exit_target_id') ? $post->entry_exit_target_id : null;
        $slip->target_code = $post->has('target_code') ? $post->target_code : null;
        $slip->payment_method_id = $post->has('payment_method_id') ? $post->payment_method_id : PaymentMethodType::CASH;
        $slip->cash_deposit_amount = $post->has('cash_deposit_amount') ? $post->cash_deposit_amount : null;
        $slip->cash_payout_amount = $post->has('cash_payout_amount') ? $post->cash_payout_amount : null;
        $slip->qr_sequence_id = $post->has('qr_sequence_id') ? $post->qr_sequence_id : null;
        $slip->qr_service_name = $post->has('qr_service_name') ? $post->qr_service_name : null;
        $slip->qr_slip_number = $post->has('qr_slip_number') ? $post->qr_slip_number : null;
        $slip->qr_trunsaction_number = $post->has('qr_trunsaction_number') ? $post->qr_trunsaction_number : null;
        $slip->credit_sequence_id = $post->has('credit_sequence_id') ? $post->credit_sequence_id : null;
        $slip->credit_service_name = $post->has('credit_service_name') ? $post->credit_service_name : null;
        $slip->credit_approval_number = $post->has('credit_approval_number') ? $post->credit_approval_number : null;
        $slip->credit_company_id = $post->has('credit_company_id') ? $post->credit_company_id : null;
        $slip->credit_condition_id = $post->has('credit_condition_id') ? $post->credit_condition_id : null;
        $slip->credit_slip_number = $post->has('credit_slip_number') ? $post->credit_slip_number : null;
        $slip->credit_trunsaction_number = $post->has('credit_trunsaction_number') ? $post->credit_trunsaction_number : null;
        $slip->ic_sequence_id = $post->has('ic_sequence_id') ? $post->ic_sequence_id : null;
        $slip->ic_service_name = $post->has('ic_service_name') ? $post->ic_service_name : null;
        $slip->ic_balance = $post->has('ic_balance') ? $post->ic_balance : null;
        $slip->ic_condition_id = $post->has('ic_condition_id') ? $post->ic_condition_id : null;
        $slip->ic_sprw_id = $post->has('ic_sprw_id') ? $post->ic_sprw_id : null;
        $slip->ic_trunsaction_number = $post->has('ic_trunsaction_number') ? $post->ic_trunsaction_number : null;
        $slip->ic_approval_number = $post->has('ic_approval_number') ? $post->ic_approval_number : null;
        $slip->ic_slip_number = $post->has('ic_slip_number') ? $post->ic_slip_number : null;
        $slip->ic_before_balance = $post->has('ic_before_balance') ? $post->ic_before_balance : null;
        $slip->is_refund = $post->has('is_refund') ? $post->is_refund : 0;
        $slip->refund_name = $post->has('refund_name') ? $post->refund_name : null;
        $slip->is_training = $post->has('is_training') ? $post->is_training : 0;
        $this->slipRepository->save($slip);
        // Make lines..
        $totalQuantity = 0;
        $totalAmountCtaxIncluded = 0;
        $totalAmountCtaxExcluded = 0;
        $totalAmountCtax = 0;
        $totalAmountCtax1Included = 0;
        $totalAmountCtax1 = 0;
        $totalAmountCtax2Included = 0;
        $totalAmountCtax2 = 0;
        $totalAmountCtax3Included = 0;
        $totalDiscountPrice = 0;
        foreach ($post->lines as $line_no => $postLine) {
            if ($postLine['product_id'] === null) {
                continue;
            }
            $line = $this->lineRepository->newEntity();
            $line->transaction_slip_id = $slip->id;
            $line->shop_id = Auth::user()->shop->id;//20230406 add
            $line->transacted_on = $trans_date;
            $line->transaction_type_id = $post->transaction_type_id; //20230406 add
            $line->category_id = $postLine['category_id']; //20230406 add
            $line->genre_id = $postLine['genre_id']; //20230406 add
            $line->line_number = $line_no + 1;
            $line->product_id = $postLine['product_id'];
            $line->product_code = $postLine['product_code'];
            $line->product_name = $postLine['product_name'];
            $line->avg_stocking_price = array_key_exists('avg_stocking_price', $postLine) ? $postLine['avg_stocking_price'] : 0;
            $line->this_stock_quantity = array_key_exists('this_stock_quantity', $postLine) ? $postLine['this_stock_quantity'] : 0;
            $line->exclude_tax = array_key_exists('exclude_tax', $postLine) ? $postLine['exclude_tax'] : 0;
            $line->include_tax = array_key_exists('include_tax', $postLine) ? $postLine['include_tax'] : 0;
            $line->quantity = array_key_exists('quantity', $postLine) ? $postLine['quantity'] : 0;
            $totalQuantity += $line->quantity;
            $line->unit_price = array_key_exists('unit_price', $postLine) ? $postLine['unit_price'] : 0;
            $line->tax_rate_type_id = array_key_exists('tax_rate_type_id', $postLine) ? $postLine['tax_rate_type_id'] : 0;
            $line->taxable_method_type_id = array_key_exists('taxable_method_type_id', $postLine) ? $postLine['taxable_method_type_id'] : 0;
            $line->final_unit_price_tax_included = array_key_exists('final_unit_price_tax_included', $postLine) ? $postLine['final_unit_price_tax_included'] : 0;
            $line->final_unit_price_tax_excluded = array_key_exists('final_unit_price_tax_excluded', $postLine) ? $postLine['final_unit_price_tax_excluded'] : 0;
            $line->subtotal_tax_included = array_key_exists('subtotal_tax_included', $postLine) ? $postLine['subtotal_tax_included'] : 0;
            $totalAmountCtaxIncluded += $line->subtotal_tax_included;
            $line->subtotal_tax_excluded = array_key_exists('subtotal_tax_excluded', $postLine) ? $postLine['subtotal_tax_excluded'] : 0;
            $totalAmountCtaxExcluded += $line->subtotal_tax_excluded;
            $line->ctax_price = array_key_exists('ctax_price', $postLine) ? $postLine['ctax_price'] : 0;
            $totalAmountCtax += $line->ctax_price;
            if ($line->taxable_method_type_id == TaxableMethodType::STANDARD_TAX) {
                $totalAmountCtax1Included += $line->subtotal_tax_included;
                $totalAmountCtax1 += $line->ctax_price;
            } elseif ($line->taxable_method_type_id == TaxableMethodType::REDUCED_TAX) {
                $totalAmountCtax2Included += $line->subtotal_tax_included;
                $totalAmountCtax2 += $line->ctax_price;
            } else {
                $totalAmountCtax3Included += $line->subtotal_tax_included;
            }
            $line->ctax_rate = array_key_exists('ctax_rate', $postLine) ? $postLine['ctax_rate'] : 0;
            $line->discount_price = array_key_exists('discount_price', $postLine) ? $postLine['discount_price'] : 0;
            $totalDiscountPrice += $line->discount_price;
            $this->lineRepository->save($line);
        }
        $slip->total_quantity = $totalQuantity;
        $slip->total_cost = $post->has('total_cost') ? $post->total_cost : 0;
        $slip->total_amount_ctax_included = $totalAmountCtaxIncluded;
        $slip->total_amount_ctax_excluded = $totalAmountCtaxExcluded;
        $slip->total_amount_ctax = $totalAmountCtax;
        $slip->total_amount_ctax1_included = $totalAmountCtax1Included;
        $slip->total_amount_ctax1 = $totalAmountCtax1;
        $slip->total_amount_ctax2_included = $totalAmountCtax2Included;
        $slip->total_amount_ctax2 = $totalAmountCtax2;
        $slip->total_amount_ctax3_included = $totalAmountCtax3Included;
        $slip->total_discount_price = $totalDiscountPrice;
        $slip->total_payment_amount = $totalAmountCtaxIncluded;
        $this->slipRepository->save($slip);
        // Change Stocks
        $this->stockRepository->changeStock($slip);
    }

    public function create_exit(ExitStockRequest $post)
    {
        $slip = $this->slipRepository->newEntity();
        $slipNumber = $this->slipService->newSlipNumber();
        // Make slip...
        $slip->shop_id = Auth::user()->shop->id;
        $trans_date = $this->shopConfigAction->get_trans_date();
        
        $slip->slip_no = $slipNumber;
        $slip->staff_id = $post['staff_id'];
        $slip->transacted_on = $trans_date;
        $slip->transaction_type_id = $post->transaction_type_id;
        $slip->customer_id = $post->has('customer_id') ? $post->customer_id : null;
        $slip->supplier_target_id = $post->has('supplier_target_id') ? $post->supplier_target_id : null;
        $slip->entry_exit_target_id = $post->has('entry_exit_target_id') ? $post->entry_exit_target_id : null;
        $slip->target_code = $post->has('target_code') ? $post->target_code : null;
        $slip->payment_method_id = $post->has('payment_method_id') ? $post->payment_method_id : PaymentMethodType::CASH;
        $slip->cash_deposit_amount = $post->has('cash_deposit_amount') ? $post->cash_deposit_amount : null;
        $slip->cash_payout_amount = $post->has('cash_payout_amount') ? $post->cash_payout_amount : null;
        $slip->qr_sequence_id = $post->has('qr_sequence_id') ? $post->qr_sequence_id : null;
        $slip->qr_service_name = $post->has('qr_service_name') ? $post->qr_service_name : null;
        $slip->qr_slip_number = $post->has('qr_slip_number') ? $post->qr_slip_number : null;
        $slip->qr_trunsaction_number = $post->has('qr_trunsaction_number') ? $post->qr_trunsaction_number : null;
        $slip->credit_sequence_id = $post->has('credit_sequence_id') ? $post->credit_sequence_id : null;
        $slip->credit_service_name = $post->has('credit_service_name') ? $post->credit_service_name : null;
        $slip->credit_approval_number = $post->has('credit_approval_number') ? $post->credit_approval_number : null;
        $slip->credit_company_id = $post->has('credit_company_id') ? $post->credit_company_id : null;
        $slip->credit_condition_id = $post->has('credit_condition_id') ? $post->credit_condition_id : null;
        $slip->credit_slip_number = $post->has('credit_slip_number') ? $post->credit_slip_number : null;
        $slip->credit_trunsaction_number = $post->has('credit_trunsaction_number') ? $post->credit_trunsaction_number : null;
        $slip->ic_sequence_id = $post->has('ic_sequence_id') ? $post->ic_sequence_id : null;
        $slip->ic_service_name = $post->has('ic_service_name') ? $post->ic_service_name : null;
        $slip->ic_balance = $post->has('ic_balance') ? $post->ic_balance : null;
        $slip->ic_condition_id = $post->has('ic_condition_id') ? $post->ic_condition_id : null;
        $slip->ic_sprw_id = $post->has('ic_sprw_id') ? $post->ic_sprw_id : null;
        $slip->ic_trunsaction_number = $post->has('ic_trunsaction_number') ? $post->ic_trunsaction_number : null;
        $slip->ic_approval_number = $post->has('ic_approval_number') ? $post->ic_approval_number : null;
        $slip->ic_slip_number = $post->has('ic_slip_number') ? $post->ic_slip_number : null;
        $slip->ic_before_balance = $post->has('ic_before_balance') ? $post->ic_before_balance : null;
        $slip->is_refund = $post->has('is_refund') ? $post->is_refund : 0;
        $slip->refund_name = $post->has('refund_name') ? $post->refund_name : null;
        $slip->is_training = $post->has('is_training') ? $post->is_training : 0;
        $this->slipRepository->save($slip);
        // Make lines..
        $totalQuantity = 0;
        $totalAmountCtaxIncluded = 0;
        $totalAmountCtaxExcluded = 0;
        $totalAmountCtax = 0;
        $totalAmountCtax1Included = 0;
        $totalAmountCtax1 = 0;
        $totalAmountCtax2Included = 0;
        $totalAmountCtax2 = 0;
        $totalAmountCtax3Included = 0;
        $totalDiscountPrice = 0;
        foreach ($post->lines as $line_no => $postLine) {
            if ($postLine['product_id'] === null) {
                continue;
            }
            $line = $this->lineRepository->newEntity();
            $line->transaction_slip_id = $slip->id;
            $line->shop_id = Auth::user()->shop->id;//20230406 add
            $line->transacted_on = $trans_date;
            $line->transaction_type_id = $post->transaction_type_id; //20230406 add
            $line->category_id = $postLine['category_id']; //20230406 add
            $line->genre_id = $postLine['genre_id']; //20230406 add
            $line->line_number = $line_no + 1;
            $line->product_id = $postLine['product_id'];
            $line->product_code = $postLine['product_code'];
            $line->product_name = $postLine['product_name'];
            $line->avg_stocking_price = array_key_exists('avg_stocking_price', $postLine) ? $postLine['avg_stocking_price'] : 0;
            $line->this_stock_quantity = array_key_exists('this_stock_quantity', $postLine) ? $postLine['this_stock_quantity'] : 0;
            $line->exclude_tax = array_key_exists('exclude_tax', $postLine) ? $postLine['exclude_tax'] : 0;
            $line->include_tax = array_key_exists('include_tax', $postLine) ? $postLine['include_tax'] : 0;
            $line->quantity = array_key_exists('quantity', $postLine) ? $postLine['quantity'] : 0;
            $totalQuantity += $line->quantity;
            $line->unit_price = array_key_exists('unit_price', $postLine) ? $postLine['unit_price'] : 0;
            $line->tax_rate_type_id = array_key_exists('tax_rate_type_id', $postLine) ? $postLine['tax_rate_type_id'] : 0;
            $line->taxable_method_type_id = array_key_exists('taxable_method_type_id', $postLine) ? $postLine['taxable_method_type_id'] : 0;
            $line->final_unit_price_tax_included = array_key_exists('final_unit_price_tax_included', $postLine) ? $postLine['final_unit_price_tax_included'] : 0;
            $line->final_unit_price_tax_excluded = array_key_exists('final_unit_price_tax_excluded', $postLine) ? $postLine['final_unit_price_tax_excluded'] : 0;
            $line->subtotal_tax_included = array_key_exists('subtotal_tax_included', $postLine) ? $postLine['subtotal_tax_included'] : 0;
            $totalAmountCtaxIncluded += $line->subtotal_tax_included;
            $line->subtotal_tax_excluded = array_key_exists('subtotal_tax_excluded', $postLine) ? $postLine['subtotal_tax_excluded'] : 0;
            $totalAmountCtaxExcluded += $line->subtotal_tax_excluded;
            $line->ctax_price = array_key_exists('ctax_price', $postLine) ? $postLine['ctax_price'] : 0;
            $totalAmountCtax += $line->ctax_price;
            if ($line->taxable_method_type_id == TaxableMethodType::STANDARD_TAX) {
                $totalAmountCtax1Included += $line->subtotal_tax_included;
                $totalAmountCtax1 += $line->ctax_price;
            } elseif ($line->taxable_method_type_id == TaxableMethodType::REDUCED_TAX) {
                $totalAmountCtax2Included += $line->subtotal_tax_included;
                $totalAmountCtax2 += $line->ctax_price;
            } else {
                $totalAmountCtax3Included += $line->subtotal_tax_included;
            }
            $line->ctax_rate = array_key_exists('ctax_rate', $postLine) ? $postLine['ctax_rate'] : 0;
            $line->discount_price = array_key_exists('discount_price', $postLine) ? $postLine['discount_price'] : 0;
            $totalDiscountPrice += $line->discount_price;
            $this->lineRepository->save($line);
        }
        $slip->total_quantity = $totalQuantity;
        $slip->total_cost = $post->has('total_cost') ? $post->total_cost : 0;
        $slip->total_amount_ctax_included = $totalAmountCtaxIncluded;
        $slip->total_amount_ctax_excluded = $totalAmountCtaxExcluded;
        $slip->total_amount_ctax = $totalAmountCtax;
        $slip->total_amount_ctax1_included = $totalAmountCtax1Included;
        $slip->total_amount_ctax1 = $totalAmountCtax1;
        $slip->total_amount_ctax2_included = $totalAmountCtax2Included;
        $slip->total_amount_ctax2 = $totalAmountCtax2;
        $slip->total_amount_ctax3_included = $totalAmountCtax3Included;
        $slip->total_discount_price = $totalDiscountPrice;
        $slip->total_payment_amount = $totalAmountCtaxIncluded;
        $this->slipRepository->save($slip);
        // Change Stocks
        $this->stockRepository->changeStock($slip);
    }

    public function create_exit_money(ExitMoneyRequest $post)
    {
        $slip = $this->slipRepository->newEntity();
        $slipNumber = $this->slipService->newSlipNumber();
        // Make slip...
        $slip->shop_id = Auth::user()->shop->id;
        $trans_date = $this->shopConfigAction->get_trans_date();
        
        $slip->slip_no = $slipNumber;
        $slip->staff_id = $post['staff_id'];
        $slip->transacted_on = $trans_date;
        $slip->transaction_type_id = $post->transaction_type_id;
        $slip->customer_id = $post->has('customer_id') ? $post->customer_id : null;
        $slip->supplier_target_id = $post->has('supplier_target_id') ? $post->supplier_target_id : null;
        $slip->entry_exit_target_id = $post->has('entry_exit_target_id') ? $post->entry_exit_target_id : null;
        $slip->target_code = $post->has('target_code') ? $post->target_code : null;
        $slip->payment_method_id = $post->has('payment_method_id') ? $post->payment_method_id : PaymentMethodType::CASH;
        $slip->cash_deposit_amount = $post->has('cash_deposit_amount') ? $post->cash_deposit_amount : null;
        $slip->cash_payout_amount = $post->has('cash_payout_amount') ? $post->cash_payout_amount : null;
        $slip->qr_sequence_id = $post->has('qr_sequence_id') ? $post->qr_sequence_id : null;
        $slip->qr_service_name = $post->has('qr_service_name') ? $post->qr_service_name : null;
        $slip->qr_slip_number = $post->has('qr_slip_number') ? $post->qr_slip_number : null;
        $slip->qr_trunsaction_number = $post->has('qr_trunsaction_number') ? $post->qr_trunsaction_number : null;
        $slip->credit_sequence_id = $post->has('credit_sequence_id') ? $post->credit_sequence_id : null;
        $slip->credit_service_name = $post->has('credit_service_name') ? $post->credit_service_name : null;
        $slip->credit_approval_number = $post->has('credit_approval_number') ? $post->credit_approval_number : null;
        $slip->credit_company_id = $post->has('credit_company_id') ? $post->credit_company_id : null;
        $slip->credit_condition_id = $post->has('credit_condition_id') ? $post->credit_condition_id : null;
        $slip->credit_slip_number = $post->has('credit_slip_number') ? $post->credit_slip_number : null;
        $slip->credit_trunsaction_number = $post->has('credit_trunsaction_number') ? $post->credit_trunsaction_number : null;
        $slip->ic_sequence_id = $post->has('ic_sequence_id') ? $post->ic_sequence_id : null;
        $slip->ic_service_name = $post->has('ic_service_name') ? $post->ic_service_name : null;
        $slip->ic_balance = $post->has('ic_balance') ? $post->ic_balance : null;
        $slip->ic_condition_id = $post->has('ic_condition_id') ? $post->ic_condition_id : null;
        $slip->ic_sprw_id = $post->has('ic_sprw_id') ? $post->ic_sprw_id : null;
        $slip->ic_trunsaction_number = $post->has('ic_trunsaction_number') ? $post->ic_trunsaction_number : null;
        $slip->ic_approval_number = $post->has('ic_approval_number') ? $post->ic_approval_number : null;
        $slip->ic_slip_number = $post->has('ic_slip_number') ? $post->ic_slip_number : null;
        $slip->ic_before_balance = $post->has('ic_before_balance') ? $post->ic_before_balance : null;
        $slip->is_refund = $post->has('is_refund') ? $post->is_refund : 0;
        $slip->refund_name = $post->has('refund_name') ? $post->refund_name : null;
        $slip->is_training = $post->has('is_training') ? $post->is_training : 0;
        $this->slipRepository->save($slip);
        // Make lines..
        $totalQuantity = 0;
        $totalAmountCtaxIncluded = 0;
        $totalAmountCtaxExcluded = 0;
        $totalAmountCtax = 0;
        $totalAmountCtax1Included = 0;
        $totalAmountCtax1 = 0;
        $totalAmountCtax2Included = 0;
        $totalAmountCtax2 = 0;
        $totalAmountCtax3Included = 0;
        $totalDiscountPrice = 0;
        foreach ($post->lines as $line_no => $postLine) {
            if ($postLine['product_id'] === null) {
                continue;
            }
            $slip->note = array_key_exists('note', $postLine) ? $postLine['note'] : null;
            $line = $this->lineRepository->newEntity();
            $line->transaction_slip_id = $slip->id;
            $line->shop_id = Auth::user()->shop->id;//20230406 add
            $line->transacted_on = $trans_date;
            $line->transaction_type_id = $post->transaction_type_id; //20230406 add
            $line->category_id = $postLine['category_id']; //20230406 add
            $line->genre_id = $postLine['genre_id']; //20230406 add
            $line->line_number = $line_no + 1;
            $line->product_id = $postLine['product_id'];
            $line->product_code = $postLine['product_code'];
            $line->product_name = $postLine['product_name'];
            $line->note = array_key_exists('note', $postLine) ? $postLine['note'] : null;
            $line->avg_stocking_price = array_key_exists('avg_stocking_price', $postLine) ? $postLine['avg_stocking_price'] : 0;
            $line->this_stock_quantity = array_key_exists('this_stock_quantity', $postLine) ? $postLine['this_stock_quantity'] : 0;
            $line->exclude_tax = array_key_exists('exclude_tax', $postLine) ? $postLine['exclude_tax'] : 0;
            $line->include_tax = array_key_exists('include_tax', $postLine) ? $postLine['include_tax'] : 0;
            $line->quantity = array_key_exists('quantity', $postLine) ? $postLine['quantity'] : 0;
            $totalQuantity += $line->quantity;
            $line->unit_price = array_key_exists('unit_price', $postLine) ? $postLine['unit_price'] : 0;
            $line->tax_rate_type_id = array_key_exists('tax_rate_type_id', $postLine) ? $postLine['tax_rate_type_id'] : 0;
            $line->taxable_method_type_id = array_key_exists('taxable_method_type_id', $postLine) ? $postLine['taxable_method_type_id'] : 0;
            $line->final_unit_price_tax_included = array_key_exists('final_unit_price_tax_included', $postLine) ? $postLine['final_unit_price_tax_included'] : 0;
            $line->final_unit_price_tax_excluded = array_key_exists('final_unit_price_tax_excluded', $postLine) ? $postLine['final_unit_price_tax_excluded'] : 0;
            $line->subtotal_tax_included = array_key_exists('subtotal_tax_included', $postLine) ? $postLine['subtotal_tax_included'] : 0;
            $totalAmountCtaxIncluded += $line->subtotal_tax_included;
            $line->subtotal_tax_excluded = array_key_exists('subtotal_tax_excluded', $postLine) ? $postLine['subtotal_tax_excluded'] : 0;
            $totalAmountCtaxExcluded += $line->subtotal_tax_excluded;
            $line->ctax_price = array_key_exists('ctax_price', $postLine) ? $postLine['ctax_price'] : 0;
            $totalAmountCtax += $line->ctax_price;
            if ($line->taxable_method_type_id == TaxableMethodType::STANDARD_TAX) {
                $totalAmountCtax1Included += $line->subtotal_tax_included;
                $totalAmountCtax1 += $line->ctax_price;
            } elseif ($line->taxable_method_type_id == TaxableMethodType::REDUCED_TAX) {
                $totalAmountCtax2Included += $line->subtotal_tax_included;
                $totalAmountCtax2 += $line->ctax_price;
            } else {
                $totalAmountCtax3Included += $line->subtotal_tax_included;
            }
            $line->ctax_rate = array_key_exists('ctax_rate', $postLine) ? $postLine['ctax_rate'] : 0;
            $line->discount_price = array_key_exists('discount_price', $postLine) ? $postLine['discount_price'] : 0;
            $totalDiscountPrice += $line->discount_price;
            $this->lineRepository->save($line);
        }
        $slip->total_quantity = $totalQuantity;
        $slip->total_cost = $post->has('total_cost') ? $post->total_cost : 0;
        $slip->total_amount_ctax_included = $totalAmountCtaxIncluded;
        $slip->total_amount_ctax_excluded = $totalAmountCtaxExcluded;
        $slip->total_amount_ctax = $totalAmountCtax;
        $slip->total_amount_ctax1_included = $totalAmountCtax1Included;
        $slip->total_amount_ctax1 = $totalAmountCtax1;
        $slip->total_amount_ctax2_included = $totalAmountCtax2Included;
        $slip->total_amount_ctax2 = $totalAmountCtax2;
        $slip->total_amount_ctax3_included = $totalAmountCtax3Included;
        $slip->total_discount_price = $totalDiscountPrice;
        $slip->total_payment_amount = $totalAmountCtaxIncluded;
        $this->slipRepository->save($slip);
        // Change Stocks
        //$this->stockRepository->changeStock($slip);
    }

    public function create_entry_money(EntryMoneyRequest $post)
    {
        $slip = $this->slipRepository->newEntity();
        $slipNumber = $this->slipService->newSlipNumber();
        // Make slip...
        $slip->shop_id = Auth::user()->shop->id;
        $trans_date = $this->shopConfigAction->get_trans_date();
        
        $slip->slip_no = $slipNumber;
        $slip->staff_id = $post['staff_id'];
        $slip->transacted_on = $trans_date;
        $slip->transaction_type_id = $post->transaction_type_id;
        $slip->customer_id = $post->has('customer_id') ? $post->customer_id : null;
        $slip->supplier_target_id = $post->has('supplier_target_id') ? $post->supplier_target_id : null;
        $slip->entry_exit_target_id = $post->has('entry_exit_target_id') ? $post->entry_exit_target_id : null;
        $slip->target_code = $post->has('target_code') ? $post->target_code : null;
        $slip->payment_method_id = $post->has('payment_method_id') ? $post->payment_method_id : PaymentMethodType::CASH;
        $slip->cash_deposit_amount = $post->has('cash_deposit_amount') ? $post->cash_deposit_amount : null;
        $slip->cash_payout_amount = $post->has('cash_payout_amount') ? $post->cash_payout_amount : null;
        $slip->qr_sequence_id = $post->has('qr_sequence_id') ? $post->qr_sequence_id : null;
        $slip->qr_service_name = $post->has('qr_service_name') ? $post->qr_service_name : null;
        $slip->qr_slip_number = $post->has('qr_slip_number') ? $post->qr_slip_number : null;
        $slip->qr_trunsaction_number = $post->has('qr_trunsaction_number') ? $post->qr_trunsaction_number : null;
        $slip->credit_sequence_id = $post->has('credit_sequence_id') ? $post->credit_sequence_id : null;
        $slip->credit_service_name = $post->has('credit_service_name') ? $post->credit_service_name : null;
        $slip->credit_approval_number = $post->has('credit_approval_number') ? $post->credit_approval_number : null;
        $slip->credit_company_id = $post->has('credit_company_id') ? $post->credit_company_id : null;
        $slip->credit_condition_id = $post->has('credit_condition_id') ? $post->credit_condition_id : null;
        $slip->credit_slip_number = $post->has('credit_slip_number') ? $post->credit_slip_number : null;
        $slip->credit_trunsaction_number = $post->has('credit_trunsaction_number') ? $post->credit_trunsaction_number : null;
        $slip->ic_sequence_id = $post->has('ic_sequence_id') ? $post->ic_sequence_id : null;
        $slip->ic_service_name = $post->has('ic_service_name') ? $post->ic_service_name : null;
        $slip->ic_balance = $post->has('ic_balance') ? $post->ic_balance : null;
        $slip->ic_condition_id = $post->has('ic_condition_id') ? $post->ic_condition_id : null;
        $slip->ic_sprw_id = $post->has('ic_sprw_id') ? $post->ic_sprw_id : null;
        $slip->ic_trunsaction_number = $post->has('ic_trunsaction_number') ? $post->ic_trunsaction_number : null;
        $slip->ic_approval_number = $post->has('ic_approval_number') ? $post->ic_approval_number : null;
        $slip->ic_slip_number = $post->has('ic_slip_number') ? $post->ic_slip_number : null;
        $slip->ic_before_balance = $post->has('ic_before_balance') ? $post->ic_before_balance : null;
        $slip->is_refund = $post->has('is_refund') ? $post->is_refund : 0;
        $slip->refund_name = $post->has('refund_name') ? $post->refund_name : null;
        $slip->is_training = $post->has('is_training') ? $post->is_training : 0;
        $this->slipRepository->save($slip);
        // Make lines..
        $totalQuantity = 0;
        $totalAmountCtaxIncluded = 0;
        $totalAmountCtaxExcluded = 0;
        $totalAmountCtax = 0;
        $totalAmountCtax1Included = 0;
        $totalAmountCtax1 = 0;
        $totalAmountCtax2Included = 0;
        $totalAmountCtax2 = 0;
        $totalAmountCtax3Included = 0;
        $totalDiscountPrice = 0;
        foreach ($post->lines as $line_no => $postLine) {
            if ($postLine['product_id'] === null) {
                continue;
            }
            $slip->note = array_key_exists('note', $postLine) ? $postLine['note'] : null;
            $line = $this->lineRepository->newEntity();
            $line->transaction_slip_id = $slip->id;
            $line->shop_id = Auth::user()->shop->id;//20230406 add
            $line->transacted_on = $trans_date;
            $line->transaction_type_id = $post->transaction_type_id; //20230406 add
            $line->category_id = $postLine['category_id']; //20230406 add
            $line->genre_id = $postLine['genre_id']; //20230406 add
            $line->line_number = $line_no + 1;
            $line->product_id = $postLine['product_id'];
            $line->product_code = $postLine['product_code'];
            $line->product_name = $postLine['product_name'];
            $line->note = array_key_exists('note', $postLine) ? $postLine['note'] : null;
            $line->avg_stocking_price = array_key_exists('avg_stocking_price', $postLine) ? $postLine['avg_stocking_price'] : 0;
            $line->this_stock_quantity = array_key_exists('this_stock_quantity', $postLine) ? $postLine['this_stock_quantity'] : 0;
            $line->exclude_tax = array_key_exists('exclude_tax', $postLine) ? $postLine['exclude_tax'] : 0;
            $line->include_tax = array_key_exists('include_tax', $postLine) ? $postLine['include_tax'] : 0;
            $line->quantity = array_key_exists('quantity', $postLine) ? $postLine['quantity'] : 0;
            $totalQuantity += $line->quantity;
            $line->unit_price = array_key_exists('unit_price', $postLine) ? $postLine['unit_price'] : 0;
            $line->tax_rate_type_id = array_key_exists('tax_rate_type_id', $postLine) ? $postLine['tax_rate_type_id'] : 0;
            $line->taxable_method_type_id = array_key_exists('taxable_method_type_id', $postLine) ? $postLine['taxable_method_type_id'] : 0;
            $line->final_unit_price_tax_included = array_key_exists('final_unit_price_tax_included', $postLine) ? $postLine['final_unit_price_tax_included'] : 0;
            $line->final_unit_price_tax_excluded = array_key_exists('final_unit_price_tax_excluded', $postLine) ? $postLine['final_unit_price_tax_excluded'] : 0;
            $line->subtotal_tax_included = array_key_exists('subtotal_tax_included', $postLine) ? $postLine['subtotal_tax_included'] : 0;
            $totalAmountCtaxIncluded += $line->subtotal_tax_included;
            $line->subtotal_tax_excluded = array_key_exists('subtotal_tax_excluded', $postLine) ? $postLine['subtotal_tax_excluded'] : 0;
            $totalAmountCtaxExcluded += $line->subtotal_tax_excluded;
            $line->ctax_price = array_key_exists('ctax_price', $postLine) ? $postLine['ctax_price'] : 0;
            $totalAmountCtax += $line->ctax_price;
            if ($line->taxable_method_type_id == TaxableMethodType::STANDARD_TAX) {
                $totalAmountCtax1Included += $line->subtotal_tax_included;
                $totalAmountCtax1 += $line->ctax_price;
            } elseif ($line->taxable_method_type_id == TaxableMethodType::REDUCED_TAX) {
                $totalAmountCtax2Included += $line->subtotal_tax_included;
                $totalAmountCtax2 += $line->ctax_price;
            } else {
                $totalAmountCtax3Included += $line->subtotal_tax_included;
            }
            $line->ctax_rate = array_key_exists('ctax_rate', $postLine) ? $postLine['ctax_rate'] : 0;
            $line->discount_price = array_key_exists('discount_price', $postLine) ? $postLine['discount_price'] : 0;
            $totalDiscountPrice += $line->discount_price;
            $this->lineRepository->save($line);
        }
        $slip->total_quantity = $totalQuantity;
        $slip->total_cost = $post->has('total_cost') ? $post->total_cost : 0;
        $slip->total_amount_ctax_included = $totalAmountCtaxIncluded;
        $slip->total_amount_ctax_excluded = $totalAmountCtaxExcluded;
        $slip->total_amount_ctax = $totalAmountCtax;
        $slip->total_amount_ctax1_included = $totalAmountCtax1Included;
        $slip->total_amount_ctax1 = $totalAmountCtax1;
        $slip->total_amount_ctax2_included = $totalAmountCtax2Included;
        $slip->total_amount_ctax2 = $totalAmountCtax2;
        $slip->total_amount_ctax3_included = $totalAmountCtax3Included;
        $slip->total_discount_price = $totalDiscountPrice;
        $slip->total_payment_amount = $totalAmountCtaxIncluded;
        $this->slipRepository->save($slip);
        // Change Stocks
        //$this->stockRepository->changeStock($slip);
    }


    /**
     * @param TransactionSlip $entity
     * @param $post
     * @return void
     */
    public function update(TransactionSlip $entity, $post)
    {
        // delete
        $this->delete($entity->id);
        // create
        switch($post->transaction_type_id){
            case TransactionType::SALES:
                $this->create_sale($post);
                break;
            case TransactionType::PURCHASE:
                $this->create_purchase($post);
                break;
            case TransactionType::ENTRY_STOCK:
                $this->create_entry($post);
                break;
            case TransactionType::EXIT_STOCK:
                $this->create_exit($post);
                break;
            case TransactionType::ENTRY_MONEY:
                $this->create_entry_money($post);
                break;
            case TransactionType::EXIT_MONEY:
                $this->create_exit_money($post);
                break;
        }
        
    }

    public function delete(int $slipId): ?bool
    {
        $slip = $this->slipRepository->get($slipId);
        if (is_null($slip)) {
            return null;
        }
        // Change Stocks
        $this->stockRepository->changeStock($slip, true);
        // Delete
        $this->lineRepository->deleteLines($slipId);
        $this->slipRepository->delete($slip);
        return true;
    }
}
