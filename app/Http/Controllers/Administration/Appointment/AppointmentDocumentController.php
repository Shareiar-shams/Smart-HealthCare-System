<?php

namespace App\Http\Controllers\Administration\Appointment;

use App\Http\Controllers\Controller;
use App\Models\Appointment\Appointment;
use App\Services\ImageService;
use Illuminate\Http\Request;

class AppointmentDocumentController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Appointment $appointment)
    
    {
        $request->validate([
            'type' => 'required|in:prescription,report,suggestion',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $path = $request->file('file')->store('appointment_documents', 'public');
        if ($request->file('file')) {
            $imageStore = $this->imageService->storeSingleImage($request->file('file'), 'categories', null, 600, 600);
        }
        $appointment->documents()->create([
            'type' => $request->type,
            'file_path' => $imageStore,
            'file_name' => $request->file('file')->getClientOriginalName(),
        ]);

        return back()->with('success', 'Document uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
