<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\TrainingDirection;
use Illuminate\View\View;

class TrainerController extends Controller
{
    public function index(): View
    {
        $trainers = Trainer::active()
            ->with(['directions', 'user'])
            ->orderBy('sort_order')
            ->get();

        $directions = TrainingDirection::active()
            ->orderBy('sort_order')
            ->get();

        return view('trainers.index', compact('trainers', 'directions'));
    }

    public function show(string $slug): View
    {
        $trainer = Trainer::active()
            ->with(['directions', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('trainers.show', compact('trainer'));
    }
}
