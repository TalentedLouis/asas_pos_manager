<?php

namespace App\Http\Controllers;

use App\Enums\SexType;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\UseCases\CustomerActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use App\Traits\BarcodeTrait;

class CustomerController extends Controller
{
    private CustomerActions $action;
    use BarcodeTrait;

    public function __construct(CustomerActions $action)
    {
        $this->action = $action;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $entities = $this->action->getAll();
        return view('customer.index', [
            'customers' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $sexTypes = SexType::asSelectArray();
        return view('customer.create',[
            'sexTypes' => $sexTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CustomerRequest $request): Redirector|RedirectResponse|Application
    {
        $this->action->create($request);
        return redirect(route('customer.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return View
     */
    public function edit(Customer $customer): View
    {
        $sexTypes = SexType::asSelectArray();
        return view('customer.edit', [
            'customer' => $customer,
            'sexTypes' => $sexTypes
        ]);
    }

    public function name_search(Request $request): View
    {
        //$product = $this->action->findByCode($jan_code);
        $param = $request->only(['keyword']);
        $param = $param['keyword'];
        //dd($param);
        $entities = $this->action->findByName($param);
        return view('customer.index', [
            'customers' => $entities
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return Application|RedirectResponse|Redirector
     */
    public function update(CustomerRequest $request, Customer $customer): Redirector|RedirectResponse|Application
    {
        $this->action->update($customer, $request);
        return redirect(route('customer.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Customer $customer): Redirector|RedirectResponse|Application
    {
        $this->action->delete($customer);
        return redirect(route('customer.index'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function code_search(Request $request): RedirectResponse
    {
        $params = $request->only(['keyword']);
        $jan_code = str_pad($params['keyword'], 12, '0', STR_PAD_LEFT);
        //  20230101 UPD S
        //$jan_code .= $this->calcCheckDigitJan13($jan_code);
        $jan_code = substr($jan_code, 0, 12).$this->calcCheckDigitJan13($jan_code);
        // 20230101 UPD E 
        $customer = $this->action->findByCode($jan_code);
        if (!$customer) {
            return redirect()->route('customer.create', ['code' => $jan_code]);
        } else {
            return redirect()->route('customer.edit', ['customer' => $customer->id]);
        }
    }
}
