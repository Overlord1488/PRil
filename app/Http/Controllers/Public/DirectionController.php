<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DirectionController extends Controller
{
    public function index(): View
    {
        return view('directions.index');
    }

    public function show(string $slug): View
    {
        return view('directions.show', compact('slug'));
    }
}
