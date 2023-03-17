<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\UseCases\CategoryActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CategoryController extends Controller
{
    private CategoryActions $action;

    public function __construct(CategoryActions $action)
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
        return view('category.index', [
            'categories' => $entities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CategoryRequest $request): Redirector|RedirectResponse|Application
    {
        $this->action->create($request);
        return redirect(route('category.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $supplierTarget
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return Application|RedirectResponse|Redirector
     */
    public function update(CategoryRequest $request, Category $category): Redirector|RedirectResponse|Application
    {
        $this->action->update($category, $request);
        return redirect(route('category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Category $category): Redirector|RedirectResponse|Application
    {
        $this->action->delete($category);
        return redirect(route('category.index'));
    }
}
