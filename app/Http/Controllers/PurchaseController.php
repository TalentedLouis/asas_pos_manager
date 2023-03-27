<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\PurchaseSearchRequest;
use App\Models\TransactionSlip;
//2023
use App\Models\TransactionLine;
//2023
use App\UseCases\TransactionActions;
//2023-03-09
use App\UseCases\ProductActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    private TransactionActions $action;
    private ProductActions $productAction;

    public function __construct(TransactionActions $action, ProductActions $productAction)
    {
        $this->action = $action;
        $this->productAction = $productAction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $fromDate = Date::now()->format(config('app.date_format'));
        $toDate = Date::now()->format(config('app.date_format'));
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::PURCHASE);
        return view('purchase.index', [
            'slips' => $slips,
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ]);
    }

    public function search(PurchaseSearchRequest $request)
    {
        $slips = $this->action->getByDate($request->from_date, $request->to_date,TransactionType::PURCHASE);
        return view('purchase.index', [
            'slips' => $slips,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $slip = new TransactionSlip();
        $slip->transaction_type_id = TransactionType::PURCHASE;
        //2023
        $line = new TransactionLine();
        //2023
        $products = $this->productAction->getAll();
        // return $products;
        return view('purchase.create', [
            'transaction_type_id' => TransactionType::PURCHASE,
            'slip' => $slip, //2023
            'line' => $line, //2023
            'products' => $products //2023-3-9
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PurchaseRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(PurchaseRequest $request)
    {
        $this->action->create_purchase($request);
        
        //return redirect(route('purchase.create'));
        $fromDate = Date::now()->format(config('app.date_format'));
        $toDate = Date::now()->format(config('app.date_format'));
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::PURCHASE);
        return view('purchase.index', [
            'slips' => $slips,
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TransactionSlip $slip
     * @return View
     */
    public function edit(TransactionSlip $slip)
    {
        $products = $this->productAction->getAll();
        return view('purchase.edit', [
            'slip' => $slip,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PurchaseRequest $request
     * @param TransactionSlip $slip
     * @return Application|RedirectResponse|Redirector
     */
    public function update(PurchaseRequest $request, TransactionSlip $slip): Redirector|RedirectResponse|Application
    {
        $this->action->update($slip, $request);
        return redirect(route('purchase.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $slip
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $slip): Redirector|RedirectResponse|Application
    {
        $this->action->delete($slip);
        return redirect(route('purchase.index'));
    }
}
