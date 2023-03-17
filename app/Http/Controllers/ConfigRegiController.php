<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRegiRequest;
use App\Models\ConfigRegi;
use App\UseCases\ConfigRegiActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ConfigRegiController extends Controller
{
    private ConfigRegiActions $actions;

    public function __construct(ConfigRegiActions $actions)
    {
        $this->actions = $actions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function index()
    {
        $entity = $this->actions->getOne();
        if ($entity === null) {
            return redirect(route('config_regi.create'));
        } else {
            return redirect(route('config_regi.edit', ['config_regi'=>$entity->id]));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('config_regi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConfigRegiRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ConfigRegiRequest $request): Redirector|RedirectResponse|Application
    {
        $this->actions->create($request);
        return redirect(route('config_regi.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigRegi $configRegi
     * @return View
     */
    public function edit(ConfigRegi $configRegi): View
    {
        return view('config_regi.edit', [
            'config_regi' => $configRegi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConfigRegiRequest $request
     * @param ConfigRegi $configRegi
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ConfigRegiRequest $request, ConfigRegi $configRegi): Redirector|RedirectResponse|Application
    {
        $this->actions->update($configRegi, $request);
        return redirect(route('config_regi.index'));
    }
}
