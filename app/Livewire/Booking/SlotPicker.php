<?php

namespace App\Livewire\Booking;

use App\Models\Trainer;
use App\Services\CreateBookingAction;
use App\Services\SlotGenerator;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;
use RuntimeException;

class SlotPicker extends Component
{
    public Trainer $trainer;

    public string $selectedDate = '';

    public string $selectedSlot = '';

    #[Validate('nullable|exists:training_directions,id')]
    public ?int $directionId = null;

    #[Validate('nullable|string|max:500')]
    public string $notes = '';

    public Collection $availableDates;

    public Collection $slots;

    public ?string $error = null;

    public bool $booked = false;

    public ?int $bookingId = null;

    public function mount(): void
    {
        $this->availableDates = app(SlotGenerator::class)->availableDates($this->trainer);
        $this->slots = collect();

        if ($this->availableDates->isNotEmpty()) {
            $this->selectedDate = $this->availableDates->first();
            $this->loadSlots();
        }
    }

    public function updatedSelectedDate(): void
    {
        $this->selectedSlot = '';
        $this->loadSlots();
    }

    public function selectSlot(string $datetime): void
    {
        $this->selectedSlot = $datetime;
    }

    public function submit(): void
    {
        $this->error = null;

        if (! $this->selectedSlot) {
            $this->error = 'Выберите время тренировки';

            return;
        }

        try {
            $booking = app(CreateBookingAction::class)->execute(
                auth()->user(),
                $this->trainer,
                Carbon::parse($this->selectedSlot),
                $this->directionId,
                $this->notes ?: null,
            );

            $this->redirect(route('bookings.show', $booking), navigate: true);
        } catch (RuntimeException $e) {
            $this->error = $e->getMessage();
            $this->loadSlots();
        }
    }

    private function loadSlots(): void
    {
        if (! $this->selectedDate) {
            $this->slots = collect();

            return;
        }

        $this->slots = app(SlotGenerator::class)->generate(
            $this->trainer,
            Carbon::parse($this->selectedDate)
        );
    }

    public function render(): View
    {
        return view('livewire.booking.slot-picker', [
            'directions' => $this->trainer->directions,
        ]);
    }
}
