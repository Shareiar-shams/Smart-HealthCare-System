<?php

namespace App\Http\Controllers\Viewport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function index()
    {
        return view('viewport.predictions.index');
    }

    public function predictHeartDisease(Request $request)
    {
        // Simple test method
        return response()->json([
            'success' => true,
            'message' => 'Heart disease prediction endpoint'
        ]);
    }

    public function predictDiabetes(Request $request)
    {
        // Simple test method
        return response()->json([
            'success' => true,
            'message' => 'Diabetes prediction endpoint'
        ]);
    }

    public function predictLiver(Request $request)
    {
        // Simple test method
        return response()->json([
            'success' => true,
            'message' => 'Liver prediction endpoint'
        ]);
    }
}