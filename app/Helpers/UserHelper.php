<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

if (!function_exists('show_role')) {

    /**
     * Get specific column value from Role by ID using pluck method.
     *
     * @param int $role_id Role ID
     * @param string $column Column name
     * @return mixed Column value or null if Role not found
     */
    function show_role(int $role_id, string $column = 'name')
    {
        $value = Role::where('id', $role_id)->pluck($column)->first();

        return $value ?? null;
    }
}

if (!function_exists('show_user_data')) {

    /**
     * Get specific column value from User by ID using pluck method.
     *
     * @param int $user_id User ID
     * @param string $column Column name
     * @return mixed Column value or null if user not found
     */
    function show_user_data(int $user_id, string $column)
    {
        $value = User::where('id', $user_id)->pluck($column)->first();

        return $value ?? null;
    }
}


if (!function_exists('profile_name_pic')) {

    /**
     * Get the initials (first letter of first name and last name) for a given user.
     *
     * @param  User  $user  The User object.
     * @return string  The initials.
     */
    function profile_name_pic($user)
    {
        // Check if user exists
        if (!$user) {
            return '';
        }

        // Get first and last names
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        // Initialize initials
        $initials = '';

        // Check if first name and last name exist, otherwise take initials from name
        if ($firstName && $lastName) {
            $firstInitial = strtoupper(substr($firstName, 0, 1));
            $lastInitial = strtoupper(substr($lastName, 0, 1));
            $initials = $firstInitial . $lastInitial;
        } else {
            // Fallback to taking two letters from the name
            $fullName = $user->name ?? '';
            $initials = strtoupper(substr($fullName, 0, 2)); // Take the first two letters
        }

        // Return the initials
        return $initials;
    }
}



if (!function_exists('show_user_name_and_avatar')) {

    /**
     * Display the user name, alias, avatar, and role in a consistent layout.
     * Automatically loads relations if not eager loaded.
     *
     * @param  \App\Models\User  $user
     * @param  bool  $name   Whether to display the user's name.
     * @param  bool  $alias  Whether to display the user's alias name.
     * @param  bool  $avatar Whether to display the user's avatar.
     * @param  bool  $role   Whether to display the user's role.
     * @return string
     */
    function show_user_name_and_avatar($user, $name = true, $alias = true, $avatar = true, $role = true)
    {
        if (!$user) {
            return '<div class="text-muted">User not found</div>';
        }

        // Ensure relations are loaded (only if not already eager loaded)
        $user->loadMissing(['employee', 'roles', 'media']);

        // ---------------- AVATAR ----------------
        $avatarHtml = '';
        if ($avatar) {
            static $mediaCache = [];

            if (isset($mediaCache[$user->id])) {
                $avatarHtml = $mediaCache[$user->id];
            } else {
                $avatarMedia = $user->getMedia('avatar')->first();

                if ($avatarMedia) {
                    $avatarUrl = $avatarMedia->getUrl('thumb');
                    $avatarHtml = '<img src="' . $avatarUrl . '" alt="' . e($user->name) . ' Avatar" class="rounded-circle">';
                } else {
                    $initials = profile_name_pic($user);
                    $avatarHtml = '<span class="avatar-initial rounded-circle bg-label-hover-dark text-bold">' . $initials . '</span>';
                }

                $mediaCache[$user->id] = $avatarHtml;
            }

            $avatarHtml = '
            <div class="avatar-wrapper">
                <div class="avatar me-2">
                    <a href="' . route('administration.settings.user.show.profile', ['user' => $user]) . '">
                        ' . $avatarHtml . '
                    </a>
                </div>
            </div>';
        }

        // ---------------- NAME ----------------
        $nameHtml = '';
        if ($name) {
            $nameHtml = '<small class="text-bold text-dark">' . e($user->name) . '</small>';
        }

        // ---------------- ALIAS ----------------
        $aliasNameHtml = '';
        if ($alias) {
            $aliasName = $user->employee ? $user->employee->alias_name : '';
            if ($aliasName) {
                $aliasNameHtml = '<a href="' . route('administration.settings.user.show.profile', ['user' => $user]) . '" target="_blank" class="text-bold">' . e($aliasName) . '</a>';
            }
        }

        // ---------------- ROLE ----------------
        $roleHtml = '';
        if ($role) {
            $roleName = $user->roles->isNotEmpty() ? $user->roles->first()->name : '';
            if ($roleName) {
                $roleHtml = '<small class="text-truncate text-muted">' . e($roleName) . '</small>';
            }
        }

        // ---------------- FINAL ----------------
        return '
        <div class="d-flex justify-content-start align-items-center user-name">
            ' . $avatarHtml . '
            <div class="d-flex flex-column">
                ' . $aliasNameHtml . '
                ' . $nameHtml . '
                ' . $roleHtml . '
            </div>
        </div>';
    }
}


