<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class YooKassaWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return response()->noContent();
    }
}
