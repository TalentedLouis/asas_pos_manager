<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigTaxRequest;
use App\Models\ConfigTax;
use App\UseCases\ConfigTaxActions;
use Illuminate\Http\Request;

class ConfigTaxController extends Controller
{
    private ConfigTaxActions $action;

    public function __construct(ConfigTaxActions $action)
    {
        $this->action = $action;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = $this->action->getAll();
        return view('config_tax.index', [
            'configTaxes' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('config_tax.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigTaxRequest $request)
    {
        $this->action->create($request);
        return redirect(route('config_tax.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfigTax  $configTax
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigTax $configTax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConfigTax  $configTax
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigTax $configTax)
    {
        return view('config_tax.edit', [
            'configTaxes' => $configTax
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConfigTax  $configTax
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigTaxRequest $request, ConfigTax $configTax)
    {
        $this->action->update($configTax, $request);
        return redirect(route('config_tax.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConfigTax  $configTax
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfigTax $configTax)
    {
        $this->action->delete($configTax);
        return redirect(route('config_tax.index'));
    }
}
