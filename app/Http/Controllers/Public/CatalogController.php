<?php

namespace App\Http\Controllers\Public;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        return view('catalog.index', ['title' => __('Каталог')]);
    }

    public function programs(): View
    {
        return view('catalog.index', [
            'title' => __('Программы тренировок'),
            'typeFilter' => 'program',
        ]);
    }

    public function nutrition(): View
    {
        $category = Category::ofType(CategoryType::Nutrition)->roots()->first();

        return view('catalog.index', [
            'title' => __('Спортивное питание'),
            'categoryFilter' => $category?->slug ?? '',
        ]);
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('catalog.index', [
            'title' => $category->name,
            'categoryFilter' => $slug,
        ]);
    }
}
