<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\EntryStockRequest;
use App\Http\Requests\EntryStockSearchRequest;
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

class EntryStockController extends Controller
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
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::ENTRY_STOCK);
        return view('entry_stock.index', [
            'slips' => $slips,
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ]);
    }

    public function search(EntryStockRequest $request)
    {
        $slips = $this->action->getByDate($request->from_date, $request->to_date,TransactionType::ENTRY_STOCK);
        return view('entry_stock.index', [
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
        $slip->transaction_type_id = TransactionType::ENTRY_STOCK;
        //2023
        $line = new TransactionLine();
        //2023
        return view('entry_stock.create', [
            'transaction_type_id' => TransactionType::ENTRY_STOCK,
            'slip' => $slip,
            //2023
            'line' => $line,
            //2023
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EntryStockRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(EntryStockRequest $request)
    {
        $this->action->create_entry($request);
        
        //return redirect(route('entry_stock.create'));

        $fromDate = Date::now()->format(config('app.date_format'));
        $toDate = Date::now()->format(config('app.date_format'));
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::ENTRY_STOCK);
        return view('entry_stock.index', [
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
        return view('entry_stock.edit', [
            'slip' => $slip,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EntryStockRequest $request
     * @param TransactionSlip $slip
     * @return Application|RedirectResponse|Redirector
     */
    public function update(EntryStockRequest $request, TransactionSlip $slip): Redirector|RedirectResponse|Application
    {
        $this->action->update($slip, $request);
        return redirect(route('entry_stock.index'));
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
        return redirect(route('entry_stock.index'));
    }
}

