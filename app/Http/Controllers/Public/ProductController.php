<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::published()
            ->with(['category', 'images', 'files'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('catalog.show', compact('product'));
    }
}
