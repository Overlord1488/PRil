<?php

namespace App\Http\Controllers\Public;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(string $trainer): View
    {
        $trainer = Trainer::active()
            ->with(['directions', 'schedules'])
            ->where('slug', $trainer)
            ->firstOrFail();

        return view('bookings.create', compact('trainer'));
    }

    public function show(Booking $booking): View
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        $booking->load(['trainer', 'direction']);

        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if(! $booking->status->isCancellable(), 422);

        $booking->update(['status' => BookingStatus::Cancelled]);

        return back()->with('success', 'Запись успешно отменена');
    }
}
