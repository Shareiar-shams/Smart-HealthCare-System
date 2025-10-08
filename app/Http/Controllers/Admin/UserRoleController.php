<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $users = User::orderBy('name')->paginate(20);
        $roles = Role::orderBy('name')->get();
        return view('admin.users.roles', compact('users', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['nullable', 'string'],
            'roles' => ['array'],
            'roles.*' => ['string'],
        ]);

        // assign single role or multiple roles
        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        } elseif (!empty($data['role'])) {
            $user->syncRoles([$data['role']]);
        } else {
            $user->syncRoles([]);
        }

        return redirect()->route('admin.users.roles')->with('success', 'User roles updated.');
    }
}
