<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Download;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('filament.admin.pages.dashboard');
        }

        if (Auth::user()->hasRole('trainer')) {
            return redirect()->route('trainer.index');
        }

        $userId = Auth::id();

        $recentOrders = Order::forUser($userId)
            ->with('items')
            ->latest()
            ->limit(3)
            ->get();

        $upcomingBookings = Booking::forUser($userId)
            ->upcoming()
            ->with('trainer')
            ->orderBy('scheduled_at')
            ->limit(3)
            ->get();

        $downloadsCount = Download::where('user_id', $userId)
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->where('downloads_count', '<', \DB::raw('max_downloads'))
            ->count();

        return view('account.index', compact('recentOrders', 'upcomingBookings', 'downloadsCount'));
    }
}
