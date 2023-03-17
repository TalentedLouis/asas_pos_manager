<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\SaleSearchRequest;
use App\Models\TransactionSlip;
//2023
use App\Models\TransactionLine;
//2023
use App\UseCases\TransactionActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    private TransactionActions $action;

    public function __construct(TransactionActions $action)
    {
        $this->action = $action;
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
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::SALES);
        return view('sale.index', [
            'slips' => $slips,
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ]);
    }

    public function search(SaleRequest $request)
    {
        $slips = $this->action->getByDate($request->from_date, $request->to_date,TransactionType::SALES);
        return view('sale.index', [
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
        $slip->transaction_type_id = TransactionType::SALES;
        //2023
        $line = new TransactionLine();
        //2023
        return view('sale.create', [
            'transaction_type_id' => TransactionType::SALES,
            'slip' => $slip,
            //2023
            'line' => $line,
            //2023
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SaleRequest $request)
    {
        $this->action->create_sale($request);
        
        //return redirect(route('sale.create'));

        $fromDate = Date::now()->format(config('app.date_format'));
        $toDate = Date::now()->format(config('app.date_format'));
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::SALES);
        return view('sale.index', [
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
        return view('sale.edit', [
            'slip' => $slip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaleRequest $request
     * @param TransactionSlip $slip
     * @return Application|RedirectResponse|Redirector
     */
    public function update(SaleRequest $request, TransactionSlip $slip): Redirector|RedirectResponse|Application
    {
        $this->action->update($slip, $request);
        return redirect(route('sale.index'));
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
        return redirect(route('sale.index'));
    }
}

