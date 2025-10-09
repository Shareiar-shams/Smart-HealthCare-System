<?php

namespace App\Http\Controllers\Administration\Setting\Permission;

use App\Http\Controllers\Controller;
use App\Models\PermissionModule;
use Exception;
use Illuminate\Http\Request;

class PermissionModuleController extends Controller
{
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:permission_modules,name'],
        ], [
            'name.unique' => 'The Permission Module Name Has Already Been Taken.'
        ]);

        try {
            PermissionModule::create([
                'name' => $request->name
            ]);

            $notofication = array(
                'message' => 'Permission Module created successfully!',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notofication);
        } catch (Exception $e) {
            $notofication = array(
                'message' => 'Permission Module created successfully!',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notofication);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PermissionModule $module)
    {
        $modules = PermissionModule::orderBy('name', 'asc')->get();

        return view('admin.settings.permission.show', compact(['modules', 'module']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermissionModule $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermissionModule $module)
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
