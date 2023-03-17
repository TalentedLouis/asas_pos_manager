<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceiptConfigRequest;
use App\Models\ReceiptConfig;
use App\UseCases\ReceiptConfigActions;
use Illuminate\Http\Request;

class ReceiptConfigController extends Controller
{
    private ReceiptConfigActions $actions;

    public function __construct(ReceiptConfigActions $actions)
    {
        $this->actions = $actions;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entity = $this->actions->getOne();
        if ($entity == null) {
            return redirect(route('receipt_config.create'));
        } else {
            return redirect(
                route('receipt_config.edit', [
                    'receipt_config' => $entity->id,
                ])
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('receipt_config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptConfigRequest $request)
    {
        $this->actions->create($request);
        return redirect(route('receipt_config.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceiptConfig  $receiptConfig
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiptConfig $receiptConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceiptConfig  $receiptConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiptConfig $receiptConfig)
    {
        return view('receipt_config.edit', [
            'receipt_config' => $receiptConfig,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReceiptConfig  $receiptConfig
     * @return \Illuminate\Http\Response
     */
    public function update(
        ReceiptConfigRequest $request,
        ReceiptConfig $receiptConfig
    ) {
        $this->actions->update($receiptConfig, $request);
        return redirect(route('receipt_config.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceiptConfig  $receiptConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiptConfig $receiptConfig)
    {
        $this->actions->delete($receiptConfig);
        return redirect(route('receipt_config.index'));
    }
}
