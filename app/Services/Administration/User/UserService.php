<?php

namespace App\Services\Administration\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * Get filtered users with their relationships
     */
    public function getFilteredUsers(array $filters = [])
    {
        $query = User::with(['role', 'roles', 'profile', 'doctor', 'pharmacy'])
            ->withCount('roles');

        // Filter by role
        if (!empty($filters['role'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->where('name', $filters['role']);
            });
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by search term (name or email)
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Sort
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $filters['paginate'] ?? false
            ? $query->paginate($filters['per_page'] ?? 15)
            : $query->get();
    }

    /**
     * Get all users with their relationships
     */
    public function getAllUsers()
    {
        return $this->getFilteredUsers();
    }

    /**
     * Get paginated users
     */
    public function getPaginatedUsers($perPage = 15)
    {
        return $this->getFilteredUsers(['paginate' => true, 'per_page' => $perPage]);
    }

    /**
     * Get user by ID with relationships
     */
    public function getUserById($id)
    {
        return User::with(['role', 'roles', 'profile', 'doctor', 'pharmacy'])
            ->findOrFail($id);
    }

    /**
     * Get all roles for dropdown
     */
    public function getAllRoles()
    {
        return Role::all();
    }

    /**
     * Create a new user
     */
    public function createUser(array $data): User
    {
        return DB::transaction(function() use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role_id'] ?? null,
            ]);

            // Assign role using Spatie
            if (isset($data['role_id'])) {
                $role = Role::find($data['role_id']);
                if ($role) {
                    $user->assignRole($role->name);
                }
            }

            return $user;
        }, 5);
    }

    /**
     * Update an existing user
     */
    public function updateUser(User $user, array $data): User
    {
        return DB::transaction(function() use ($user, $data) {
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'] ?? null,
            ];

            // Only update password if provided
            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            // Update role using Spatie
            if (isset($data['role_id'])) {
                $role = Role::find($data['role_id']);
                if ($role) {
                    $user->syncRoles([$role->name]);
                }
            }

            return $user->fresh();
        }, 5);
    }

    /**
     * Update user status
     */
    public function updateStatus(User $user, string $status): User
    {
        $user->update(['status' => $status]);
        return $user->fresh();
    }

    /**
     * Delete a user (soft delete)
     */
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Get user statistics
     */
    public function getUserStatistics(User $user): array
    {
        return [
            'role_count' => $user->roles()->count(),
            'permission_count' => $user->getAllPermissions()->count(),
            'created_at' => $user->created_at,
            'status' => $user->status ?? 'Active',
        ];
    }

    /**
     * Generate success message for user operations
     */
    public function generateSuccessMessage(string $action, User $user): string
    {
        return "User '{$user->name}' has been {$action} successfully.";
    }

    /**
     * Generate error message for user operations
     */
    public function generateErrorMessage(string $action, Exception $e): string
    {
        return "Failed to {$action} user: " . $e->getMessage();
    }
}