<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\ExitMoneyRequest;
use App\Http\Requests\ExitMoneySearchRequest;
use App\Models\TransactionSlip;
use App\Models\TransactionLine;
use App\UseCases\TransactionActions;
use App\UseCases\ProductActions;
use App\UseCases\ShopConfigActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class ExitMoneyController extends Controller
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
        $shopConfigAction = App::make(ShopConfigActions::class);
        $trans_date = $shopConfigAction->get_trans_date();
        $slips = $this->action->getByDate($trans_date, $trans_date,TransactionType::EXIT_MONEY);
        return view('exit_money.index', [
            'slips' => $slips,
            'from_date' => $trans_date,
            'to_date' => $trans_date,
            'trans_date' => $trans_date,
        ]);
    }

    public function search(ExitMoneySearchRequest $request)
    {
        $slips = $this->action->getByDate($request->from_date, $request->to_date,TransactionType::EXIT_MONEY);
        $shopConfigAction = App::make(ShopConfigActions::class);
        $trans_date = $shopConfigAction->get_trans_date();
        return view('exit_money.index', [
            'slips' => $slips,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'trans_date' => $trans_date,
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
        $slip->transaction_type_id = TransactionType::EXIT_MONEY;
        $line = new TransactionLine();
        $products = $this->productAction->getAll();
        $shopConfigAction = App::make(ShopConfigActions::class);
        $trans_date = $shopConfigAction->get_trans_date();
        return view('exit_money.create', [
            'transaction_type_id' => TransactionType::EXIT_MONEY,
            'slip' => $slip,
            'line' => $line,
            'products' => $products,
            'trans_date' => $trans_date,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExitMoneyRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ExitMoneyRequest $request)
    {
        $this->action->create_exit_money($request);
        $shopConfigAction = App::make(ShopConfigActions::class);
        $trans_date = $shopConfigAction->get_trans_date();
        $slips = $this->action->getByDate($trans_date, $trans_date,TransactionType::EXIT_MONEY);
        return view('exit_money.index', [
            'slips' => $slips,
            'from_date' => $trans_date,
            'to_date' => $trans_date,
            'trans_date' => $trans_date,
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
        $shopConfigAction = App::make(ShopConfigActions::class);
        $trans_date = $shopConfigAction->get_trans_date();
        return view('exit_money.edit', [
            'slip' => $slip,
            'products' => $products,
            'trans_date' => $trans_date,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExitStockRequest $request
     * @param TransactionSlip $slip
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ExitMoneyRequest $request, TransactionSlip $slip): Redirector|RedirectResponse|Application
    {
        $this->action->update($slip, $request);
        return redirect(route('exit_money.index'));
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
        return redirect(route('exit_money.index'));
    }
}

