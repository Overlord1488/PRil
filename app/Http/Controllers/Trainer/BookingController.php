<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('trainer.bookings.index');
    }

    public function complete(string $booking): RedirectResponse
    {
        return back();
    }

    public function noShow(string $booking): RedirectResponse
    {
        return back();
    }

    public function cancel(string $booking): RedirectResponse
    {
        return back();
    }
}
