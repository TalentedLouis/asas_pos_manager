<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierTargetRequest;
use App\Models\SupplierTarget;
use App\UseCases\SupplierTargetActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class SupplierTargetController extends Controller
{
    private SupplierTargetActions $action;

    public function __construct(SupplierTargetActions $action)
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
        return view('supplier_target.index', [
            'supplierTargets' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('supplier_target.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SupplierTargetRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SupplierTargetRequest $request): Redirector|RedirectResponse|Application
    {
        $this->action->create($request);
        return redirect(route('supplier_target.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SupplierTarget $supplierTarget
     * @return View
     */
    public function edit(SupplierTarget $supplierTarget): View
    {
        return view('supplier_target.edit', [
            'supplierTargets' => $supplierTarget
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SupplierTargetRequest $request
     * @param SupplierTarget $supplierTarget
     * @return Application|RedirectResponse|Redirector
     */
    public function update(SupplierTargetRequest $request, SupplierTarget $supplierTarget): Redirector|RedirectResponse|Application
    {
        $this->action->update($supplierTarget, $request);
        return redirect(route('supplier_target.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SupplierTarget $supplierTarget
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(SupplierTarget $supplierTarget): Redirector|RedirectResponse|Application
    {
        $this->action->delete($supplierTarget);
        return redirect(route('supplier_target.index'));
    }
}
