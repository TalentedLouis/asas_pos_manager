<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Models\Staff;
use App\Services\ShopService;
use App\UseCases\StaffActions;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    private StaffActions $action;
    private ShopService $shopService;

    public function __construct(StaffActions $action, ShopService $shopService)
    {
        $this->action = $action;
        $this->shopService = $shopService;
    }

    public function getShops()
    {
        return $this->shopService->getSelect();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = $this->action->getAll();
        return view('staff.index', [
            'staffs' => $entities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Staff $staff)
    {
        // $shops = $this->getShops();
        return view('staff.create', [
            // 'shops' => $shops,
            'staff' => $staff,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $this->action->create($request);
        return redirect(route('staff.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        // $shops = $this->getShops();
        return view('staff.edit', [
            'staff' => $staff,
            // 'shops' => $shops,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $this->action->update($staff, $request);
        return redirect(route('staff.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $this->action->delete($staff);
        return redirect(route('staff.index'));
    }
}
