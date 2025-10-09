<?php

namespace App\Http\Controllers\Administration\Setting\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Settings\Permission\PermissionStoreRequest;
use App\Http\Requests\Administration\Settings\Permission\PermissionUpdateRequest;
use App\Models\PermissionModule;
use Exception;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = PermissionModule::with(['permissions'])->orderBy('name', 'asc')->get();
        return view('admin.settings.permission.index',compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = PermissionModule::orderBy('name', 'asc')->get();
        return view('admin.settings.permission.create', compact(['modules']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionStoreRequest $request)
    {
        $permissionModuleId = $request->input('permission_module_id');
        $moduleName = PermissionModule::whereId($permissionModuleId)->value('name');
        
        $actions = ['Everything', 'Create', 'Read', 'Update', 'Delete'];

        try {
            foreach ($actions as $action) {
                if ($request->has('name.' . $action)) {
                    $permissionName = ucfirst($moduleName) . ' ' . ucfirst($action);
                    
                    Permission::create([
                        'permission_module_id' => $permissionModuleId,
                        'name' => $permissionName,
                    ]);
                }
            }

            $notofication = array(
                'message' => 'Permission created successfully!',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notofication);
        } catch (Exception $e) {
            $notofication = array(
                'message' => 'Something went wrong! ' . $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notofication);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $modules = PermissionModule::orderBy('name', 'asc')->get();
        return view('admin.settings.permission.show', compact(['modules', 'permission']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
