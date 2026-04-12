<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $trainer = Trainer::where('user_id', Auth::id())->first();

        if (! $trainer) {
            return view('trainer.index', ['trainer' => null]);
        }

        $upcoming = Booking::where('trainer_id', $trainer->id)
            ->upcoming()
            ->with('user')
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();

        $todayCount = Booking::where('trainer_id', $trainer->id)
            ->whereDate('scheduled_at', today())
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->count();

        $totalCount = Booking::where('trainer_id', $trainer->id)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->count();

        return view('trainer.index', compact('trainer', 'upcoming', 'todayCount', 'totalCount'));
    }
}
