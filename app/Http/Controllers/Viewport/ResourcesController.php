<?php

namespace App\Http\Controllers\Viewport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function index()
    {
        return view('viewport.resources.index');
    }

    public function showCategory($category)
    {
        return view('viewport.resources.resource-category', ['category' => $category]);
    }
}