<?php

namespace App\Http\Middleware;

use App\Services\CartManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AttachGuestCart
{
    public function __construct(private readonly CartManager $cartManager) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->session()->has('guest_cart_session')) {
            $guestSession = $request->session()->pull('guest_cart_session');
            $this->cartManager->mergeGuestCart($guestSession);
        } elseif (! Auth::check()) {
            $request->session()->put('guest_cart_session', $request->session()->getId());
        }

        return $next($request);
    }
}
