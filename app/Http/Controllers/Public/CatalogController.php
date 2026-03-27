<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        return view('catalog.index');
    }

    public function programs(): View
    {
        return view('catalog.index', ['typeFilter' => 'program']);
    }

    public function nutrition(): View
    {
        return view('catalog.index', ['typeFilter' => 'nutrition']);
    }

    public function category(string $slug): View
    {
        return view('catalog.index', ['categorySlug' => $slug]);
    }
}
