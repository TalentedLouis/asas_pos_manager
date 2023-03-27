<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\ExitStockRequest;
use App\Http\Requests\ExitStockSearchRequest;
use App\Models\TransactionSlip;
//2023
use App\Models\TransactionLine;
//2023
use App\UseCases\TransactionActions;
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

class ExitStockController extends Controller
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
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::EXIT_STOCK);
        return view('exit_stock.index', [
            'slips' => $slips,
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ]);
    }

    public function search(ExitStockRequest $request)
    {
        $slips = $this->action->getByDate($request->from_date, $request->to_date,TransactionType::EXIT_STOCK);
        return view('exit_stock.index', [
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
        $slip->transaction_type_id = TransactionType::EXIT_STOCK;
        //2023
        $line = new TransactionLine();
        $products = $this->productAction->getAll();
        //2023
        return view('exit_stock.create', [
            'transaction_type_id' => TransactionType::EXIT_STOCK,
            'slip' => $slip,
            'line' => $line,
            'products' => $products //2023-3-9
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExitStockRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ExitStockRequest $request)
    {
        $this->action->create_exit($request);
        
        //return redirect(route('sale.create'));

        $fromDate = Date::now()->format(config('app.date_format'));
        $toDate = Date::now()->format(config('app.date_format'));
        $slips = $this->action->getByDate($fromDate, $toDate,TransactionType::EXIT_STOCK);
        return view('exit_stock.index', [
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
        return view('exit_stock.edit', [
            'slip' => $slip,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExitStockRequest $request
     * @param TransactionSlip $slip
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ExitStockRequest $request, TransactionSlip $slip): Redirector|RedirectResponse|Application
    {
        $this->action->update($slip, $request);
        return redirect(route('exit_stock.index'));
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
        return redirect(route('exit_stock.index'));
    }
}

