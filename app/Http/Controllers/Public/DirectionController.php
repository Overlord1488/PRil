<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\TrainingDirection;
use Illuminate\View\View;

class DirectionController extends Controller
{
    public function index(): View
    {
        $directions = TrainingDirection::active()
            ->withCount('trainers')
            ->orderBy('sort_order')
            ->get();

        return view('directions.index', compact('directions'));
    }

    public function show(string $slug): View
    {
        $direction = TrainingDirection::active()
            ->with(['trainers' => fn ($q) => $q->active()->with('directions')])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('directions.show', compact('direction'));
    }
}
