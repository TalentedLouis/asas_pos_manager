<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use App\UseCases\ShopActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ShopController extends Controller
{
    private ShopActions $action;

    public function __construct(ShopActions $action)
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
        $shops = $this->action->getAll();
        return view("shop.index", [
            "shops" => $shops,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view("shop.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ShopRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(
        ShopRequest $request
    ): Redirector|RedirectResponse|Application {
        $this->action->create($request);
        //$this->action->jsonUpload();
        return redirect(route("shop.index"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Shop $shop
     * @return View
     */
    public function edit(Shop $shop): View
    {
        return view("shop.edit", [
            "shop" => $shop,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShopRequest $request
     * @param Shop $shop
     * @return Application|RedirectResponse|Redirector
     */
    public function update(
        ShopRequest $request,
        Shop $shop
    ): Redirector|RedirectResponse|Application {
        $this->action->update($shop, $request);
        $this->action->jsonUpload();
        return redirect(route("shop.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Shop $shop
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Shop $shop): Redirector|RedirectResponse|Application
    {
        $this->action->delete($shop);
        //$this->action->jsonUpload();
        return redirect(route("shop.index"));
    }
}
