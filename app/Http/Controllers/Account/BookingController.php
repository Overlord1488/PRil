<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('account.bookings.index');
    }

    public function cancel(string $booking): RedirectResponse
    {
        return back();
    }
}
