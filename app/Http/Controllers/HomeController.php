<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;

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

    /**
     * cache clear
     */
    public function cache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return redirect()->back()->with([
            'message' => 'Application Cache Cleared Successfully!',
            'alert-type' => 'success',
        ]);
    }
}
