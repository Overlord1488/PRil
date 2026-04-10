<?php

namespace App\Http\Controllers\Account;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $upcoming = Booking::forUser($userId)
            ->upcoming()
            ->with(['trainer', 'direction'])
            ->orderBy('scheduled_at')
            ->get();

        $past = Booking::forUser($userId)
            ->where(fn ($q) => $q->where('scheduled_at', '<', now())
                ->orWhere('status', BookingStatus::Cancelled))
            ->with(['trainer', 'direction'])
            ->orderByDesc('scheduled_at')
            ->limit(20)
            ->get();

        return view('account.bookings.index', compact('upcoming', 'past'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if(! $booking->status->isCancellable(), 422);

        $booking->update(['status' => BookingStatus::Cancelled]);

        return back()->with('success', 'Запись отменена');
    }
}
