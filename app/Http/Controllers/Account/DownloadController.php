<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(): View
    {
        return view('account.downloads.index');
    }

    public function download(string $download): never
    {
        abort(404);
    }
}
