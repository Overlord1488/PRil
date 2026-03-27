<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(): View
    {
        return view('trainer.schedule.index');
    }

    public function store(Request $request): RedirectResponse
    {
        return back();
    }

    public function exceptions(): View
    {
        return view('trainer.schedule.exceptions');
    }

    public function storeException(Request $request): RedirectResponse
    {
        return back();
    }

    public function destroyException(string $exception): RedirectResponse
    {
        return back();
    }
}
