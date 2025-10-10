<?php

namespace App\Http\Controllers\Administration\Setting\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Settings\Role\RoleStoreRequest;
use App\Http\Requests\Administration\Settings\Role\RoleUpdateRequest;
use App\Services\Administration\Settings\Role\RoleService;
use Exception;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = $this->roleService->getAllRolesWithStats();
        return view('admin.settings.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role
     */
    public function create()
    {
        $modules = $this->roleService->getPermissionModules();
        return view('admin.settings.role.create', compact('modules'));
    }

    /**
     * Store a newly created role
     */
    public function store(RoleStoreRequest $request)
    {
        try {
            $role = $this->roleService->createRole($request->validated());

            $message = $this->roleService->generateSuccessMessage('created', $role, count($request->input('permissions', [])));

            $notiication = array(
                'message' => $message,
                'alert-type' => 'success'
            );
            return redirect()->route('administration.settings.rolepermission.role.show', ['role' => $role])->with($notiication);
        } catch (Exception $e) {
            $message = $this->roleService->generateErrorMessage('create', $e);

            $notiication = array(
                'message' => $message,
                'alert-type' => 'error'
            );
            return redirect()->back()->withInput($notiication);
        }
    }

    /**
     * Display the specified role
     */
    public function show(Role $role)
    {
        $permissionModules = $this->roleService->getRolePermissionModules($role);
        return view('admin.settings.role.show', compact('role', 'permissionModules'));
    }

    /**
     * Show the form for editing the specified role
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $modules = $this->roleService->getPermissionModules();

        return view('admin.settings.role.edit', compact('modules', 'role'));
    }

    /**
     * Update the specified role
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        
        try {
            $originalPermissionCount = $role->permissions->count();
            $this->roleService->updateRole($role, $request->validated());

            $message = $this->roleService->generateUpdateSuccessMessage($role, $originalPermissionCount, count($request->input('permissions', [])));
            
            $notiication = array(
                'message' => $message,
                'alert-type' => 'success'
            );
            return redirect()->route('administration.settings.rolepermission.role.show', ['role' => $role])->with($notiication);
        } catch (Exception $e) {
            $message = $this->roleService->generateErrorMessage('update', $e);

            $notiication = array(
                'message' => $message,
                'alert-type' => 'error'
            );
            return redirect()->back()->withInput($notiication);
        }
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role)
    {
        abort(403, 'Role deletion is currently disabled for security reasons.');
    }
}
