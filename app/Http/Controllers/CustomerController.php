<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\UseCases\CustomerActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CustomerController extends Controller
{
    private CustomerActions $action;

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
        return view('customer.create');
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
        return view('customer.edit', [
            'customer' => $customer
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
}
