<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Services\DownloadDelivery;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(): View
    {
        $downloads = Download::where('user_id', Auth::id())
            ->with(['productFile', 'orderItem.product'])
            ->latest()
            ->get();

        return view('account.downloads.index', compact('downloads'));
    }

    public function download(Download $download, DownloadDelivery $delivery): Response
    {
        abort_if($download->user_id !== Auth::id(), 403);

        return $delivery->deliver($download->id, Auth::id());
    }
}
