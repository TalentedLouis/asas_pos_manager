<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakerRequest;
use App\Models\Maker;
use App\UseCases\MakerActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class MakerController extends Controller
{
    private MakerActions $action;

    public function __construct(MakerActions $action)
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
        return view('maker.index', [
            'makers' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('maker.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MakerRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(MakerRequest $request): Redirector|RedirectResponse|Application
    {
        $this->action->create($request);
        return redirect(route('maker.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Maker $maker
     * @return View
     */
    public function edit(Maker $maker): View
    {
        return view('maker.edit', [
            'maker' => $maker
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MakerRequest $request
     * @param Maker $maker
     * @return Application|RedirectResponse|Redirector
     */
    public function update(MakerRequest $request, Maker $maker): Redirector|RedirectResponse|Application
    {
        $this->action->update($maker, $request);
        return redirect(route('maker.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Maker $maker
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Maker $maker): Redirector|RedirectResponse|Application
    {
        $this->action->delete($maker);
        return redirect(route('maker.index'));
    }
}
