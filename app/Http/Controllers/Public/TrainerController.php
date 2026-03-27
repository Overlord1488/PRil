<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TrainerController extends Controller
{
    public function index(): View
    {
        return view('trainers.index');
    }

    public function show(string $slug): View
    {
        return view('trainers.show', compact('slug'));
    }
}
