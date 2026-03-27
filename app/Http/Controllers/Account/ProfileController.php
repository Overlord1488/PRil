<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('account.profile');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->user()->update($request->only('name', 'phone'));

        return back()->with('status', __('Профиль обновлён.'));
    }
}
