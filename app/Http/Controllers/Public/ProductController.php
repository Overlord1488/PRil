<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        return view('catalog.show', compact('slug'));
    }
}
