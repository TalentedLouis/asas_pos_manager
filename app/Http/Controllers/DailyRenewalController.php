<?php

namespace App\Http\Controllers;

use App\Http\Requests\DailyRenewalRequest;
use App\Models\ShopConfig;
use App\UseCases\ShopConfigActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

use DateTime;

class DailyRenewalController extends Controller
{
    private ShopConfigActions $action;

    public function __construct(ShopConfigActions $action)
    {
        $this->action = $action;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Redirector|RedirectResponse|Application
     */
    public function index(): view
    {
        $entity = $this->action->get();
        $renewal_date = $this->action->get_renewal_date();

        if ($entity===null) {
            return null;
        } else {
            return view('daily_renewal.edit', [
                'shop_config' => $entity,
                'renewal_date' => $renewal_date
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DailyRenewalRequest $request
     * @param ShopConfig $shopConfig
     * @return Application|RedirectResponse|Redirector
     */
    public function update(DailyRenewalRequest $request,string $id): RedirectResponse
    {
        $shopConfig = $this->action->find((int)$id);
        $this->action->daily_renewal($shopConfig, $request);
        return redirect()->route('dashboard');
        //return redirect()->route('daily_renewal.index');
    }
}
