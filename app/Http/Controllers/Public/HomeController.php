<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\TrainingDirection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $trainers = Trainer::active()
            ->with('directions')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        $directions = TrainingDirection::active()
            ->withCount('trainers')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $trainerCount = Trainer::active()->count();
        $directionCount = TrainingDirection::active()->count();

        return view('public.home', compact('trainers', 'directions', 'trainerCount', 'directionCount'));
    }
}
