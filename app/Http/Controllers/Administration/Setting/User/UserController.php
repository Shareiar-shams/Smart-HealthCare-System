<?php

namespace App\Http\Controllers\Administration\Setting\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Administration\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.settings.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = $this->userService->getAllRoles();
        return view('admin.settings.user.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = $this->userService->createUser($request->all());

            $message = $this->userService->generateSuccessMessage('created', $user);

            $notification = array(
                'message' => $message,
                'alert-type' => 'success'
            );
            return redirect()->route('administration.settings.user.index')->with($notification);
        } catch (Exception $e) {
            $message = $this->userService->generateErrorMessage('create', $e);

            $notification = array(
                'message' => $message,
                'alert-type' => 'error'
            );
            return redirect()->back()->withInput()->with($notification);
        }
    }

    /**
     * Display the specified user profile
     */
    public function showProfile(User $user)
    {
        $statistics = $this->userService->getUserStatistics($user);
        return view('admin.settings.user.show', compact('user', 'statistics'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $roles = $this->userService->getAllRoles();
        return view('admin.settings.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->userService->updateUser($user, $request->all());

            $message = $this->userService->generateSuccessMessage('updated', $user);

            $notification = array(
                'message' => $message,
                'alert-type' => 'success'
            );
            return redirect()->route('administration.settings.user.index')->with($notification);
        } catch (Exception $e) {
            $message = $this->userService->generateErrorMessage('update', $e);

            $notification = array(
                'message' => $message,
                'alert-type' => 'error'
            );
            return redirect()->back()->withInput()->with($notification);
        }
    }

    /**
     * Update user status
     */
    public function updateStatus(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status value'
            ], 422);
        }

        try {
            $this->userService->updateStatus($user, $request->status);

            return response()->json([
                'success' => true,
                'message' => "User status updated to {$request->status} successfully."
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user);

            $message = $this->userService->generateSuccessMessage('deleted', $user);

            $notification = array(
                'message' => $message,
                'alert-type' => 'success'
            );
            return redirect()->route('administration.settings.user.index')->with($notification);
        } catch (Exception $e) {
            $message = $this->userService->generateErrorMessage('delete', $e);

            $notification = array(
                'message' => $message,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
