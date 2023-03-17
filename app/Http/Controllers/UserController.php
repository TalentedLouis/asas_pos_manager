<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ShopService;
use App\UseCases\UserActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserActions $action;
    private ShopService $shopService;

    public function __construct(
        UserActions $action,
        ShopService $shopService
    )
    {
        $this->action = $action;
        $this->shopService = $shopService;
    }

    public function index(): View
    {
        $entities = $this->action->getAll();
        return view('user.index', [
            'users' => $entities,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $shops = $this->shopService->getSelect();
        return view('user.edit', [
            'user' => $user,
            'shops' => $shops,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UserRequest $request, User $user): Redirector|RedirectResponse|Application
    {
        $this->action->update($user, $request);
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(User $user): Redirector|RedirectResponse|Application
    {
        $this->action->delete($user);
        return redirect(route('user.index'));
    }
}
