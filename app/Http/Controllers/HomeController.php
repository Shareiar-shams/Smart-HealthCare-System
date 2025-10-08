<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }

    /**
     * Display a listing of admin activities.
     */
    public function activities(): View
    {
        $user = auth()->user();
        $activities = $user->activities()->latest()->get();
 
        return view('admin.dashboard.activities.index', compact('activities'));
    }
}
