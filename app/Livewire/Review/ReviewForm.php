<?php

namespace App\Livewire\Review;

use App\Models\Review;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReviewForm extends Component
{
    public string $reviewableType;

    public int $reviewableId;

    #[Validate('required|integer|min:1|max:5')]
    public int $rating = 0;

    #[Validate('nullable|string|min:10|max:1000')]
    public string $body = '';

    public bool $submitted = false;

    public ?Review $existing = null;

    public function mount(): void
    {
        if (auth()->check()) {
            $this->existing = Review::where('user_id', auth()->id())
                ->where('reviewable_type', $this->reviewableType)
                ->where('reviewable_id', $this->reviewableId)
                ->first();

            if ($this->existing) {
                $this->rating = $this->existing->rating;
                $this->body = $this->existing->body ?? '';
            }
        }
    }

    public function setRating(int $value): void
    {
        $this->rating = $value;
    }

    public function submit(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $this->validate();

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'reviewable_type' => $this->reviewableType,
                'reviewable_id' => $this->reviewableId,
            ],
            [
                'rating' => $this->rating,
                'body' => $this->body ?: null,
                'is_approved' => false,
            ]
        );

        $this->submitted = true;
    }

    public function render(): View
    {
        return view('livewire.review.review-form');
    }
}
