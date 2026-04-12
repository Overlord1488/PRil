<?php

namespace App\Http\Controllers\Trainer;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    private function getTrainer(): ?Trainer
    {
        return Trainer::where('user_id', Auth::id())->first();
    }

    public function index(): View
    {
        $trainer = $this->getTrainer();

        $upcoming = collect();
        $past = collect();

        if ($trainer) {
            $upcoming = Booking::where('trainer_id', $trainer->id)
                ->upcoming()
                ->with(['user', 'direction'])
                ->orderBy('scheduled_at')
                ->get();

            $past = Booking::where('trainer_id', $trainer->id)
                ->where(fn ($q) => $q->where('scheduled_at', '<', now())
                    ->orWhereIn('status', [
                        BookingStatus::Cancelled->value,
                        BookingStatus::NoShow->value,
                        BookingStatus::Completed->value,
                    ])
                )
                ->with(['user', 'direction'])
                ->orderByDesc('scheduled_at')
                ->limit(30)
                ->get();
        }

        return view('trainer.bookings.index', compact('trainer', 'upcoming', 'past'));
    }

    public function complete(Booking $booking): RedirectResponse
    {
        $this->authorizeBooking($booking);

        $booking->update(['status' => BookingStatus::Completed]);

        return back()->with('success', 'Тренировка отмечена как завершённая');
    }

    public function noShow(Booking $booking): RedirectResponse
    {
        $this->authorizeBooking($booking);

        $booking->update(['status' => BookingStatus::NoShow]);

        return back()->with('success', 'Отмечено: клиент не явился');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorizeBooking($booking);
        abort_if(! $booking->status->isCancellable(), 422);

        $booking->update(['status' => BookingStatus::Cancelled]);

        return back()->with('success', 'Запись отменена');
    }

    private function authorizeBooking(Booking $booking): void
    {
        $trainer = $this->getTrainer();
        abort_if(! $trainer || $booking->trainer_id !== $trainer->id, 403);
    }
}
