<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use App\UseCases\GenreActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class GenreController extends Controller
{
    private GenreActions $action;

    public function __construct(GenreActions $action)
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
        return view('genre.index', [
            'genres' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('genre.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GenreRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(GenreRequest $request): Redirector|RedirectResponse|Application
    {
        $this->action->create($request);
        return redirect(route('genre.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Genre $genre
     * @return View
     */
    public function edit(Genre $genre): View
    {
        return view('genre.edit', [
            'genre' => $genre
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GenreRequest $request
     * @param Genre $genre
     * @return Application|RedirectResponse|Redirector
     */
    public function update(GenreRequest $request, Genre $genre): Redirector|RedirectResponse|Application
    {
        $this->action->update($genre, $request);
        return redirect(route('genre.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Genre $genre
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Genre $genre): Redirector|RedirectResponse|Application
    {
        $this->action->delete($genre);
        return redirect(route('genre.index'));
    }
}
