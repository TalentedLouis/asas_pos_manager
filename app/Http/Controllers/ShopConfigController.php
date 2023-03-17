<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopConfigRequest;
use App\Models\ShopConfig;
use App\UseCases\ShopConfigActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ShopConfigController extends Controller
{
    private ShopConfigActions $action;

    public function __construct(ShopConfigActions $action)
    {
        $this->action = $action;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function index(): Redirector|RedirectResponse|Application
    {
        $entity = $this->action->get();
        if ($entity===null) {
            return redirect(route('shop_config.create'));
        } else {
            return redirect(route('shop_config.edit', [
                'shop_config' => $entity->id,
            ]));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('shop_config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ShopConfigRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ShopConfigRequest $request): Redirector|RedirectResponse|Application
    {
        $this->action->create($request);
        return redirect(route('shop_config.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ShopConfig $shopConfig
     * @return View
     */
    public function edit(ShopConfig $shopConfig): View
    {
        return view('shop_config.edit', [
            'shop_config' => $shopConfig
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShopConfigRequest $request
     * @param ShopConfig $shopConfig
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ShopConfigRequest $request, ShopConfig $shopConfig): Redirector|RedirectResponse|Application
    {
        $this->action->update($shopConfig, $request);
        return redirect(route('shop_config.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ShopConfig $shopConfig
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(ShopConfig $shopConfig): Redirector|RedirectResponse|Application
    {
        $this->action->delete($shopConfig);
        return redirect(route('shop_config.index'));
    }
}
