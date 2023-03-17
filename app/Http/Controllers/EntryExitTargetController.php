<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryExitTargetRequest;
use App\Models\EntryExitTarget;
use App\UseCases\EntryExitTargetActions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EntryExitTargetController extends Controller
{
    private EntryExitTargetActions $action;

    public function __construct(EntryExitTargetActions $action)
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
        return view('entry_exit_target.index', [
            'entryExitTargets' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entry_exit_target.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryExitTargetRequest $request)
    {
        $this->action->create($request);
        return redirect(route('entry_exit_target.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntryExitTarget  $entryExitTarget
     * @return \Illuminate\Http\Response
     */
    public function show(EntryExitTarget $entryExitTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntryExitTarget  $entryExitTarget
     * @return \Illuminate\Http\Response
     */
    public function edit(EntryExitTarget $entryExitTarget)
    {
        return view('entry_exit_target.edit', [
            'entryExitTarget' => $entryExitTarget
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryExitTarget  $entryExitTarget
     * @return \Illuminate\Http\Response
     */
    public function update(EntryExitTargetRequest $request, EntryExitTarget $entryExitTarget)
    {
        $this->action->update($entryExitTarget,$request);
        return redirect(route('entry_exit_target.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntryExitTarget  $entryExitTarget
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntryExitTarget $entryExitTarget)
    {
        $this->action->delete($entryExitTarget);
        return redirect(route('entry_exit_target.index'));
    }
}
