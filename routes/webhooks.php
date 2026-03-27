<?php

use App\Http\Controllers\Webhooks\YooKassaWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/yookassa', YooKassaWebhookController::class)->name('webhooks.yookassa');
