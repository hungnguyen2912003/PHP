<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    'login' => [
        'account_not_found' => 'Account not found.',
        'no_admin_permission' => 'You do not have admin access.',
        'invalid_credentials' => 'Invalid login credentials.',
        'status' => [
            'success' => 'Login successful.',
        ]
    ],

    'register' => [
        'success' => 'Registration successful! Please check your email to activate your account.',
        'user_exists' => 'Email or username is already taken.',
    ],

    'logout' => [
        'status' => [
            'success' => 'Logout successful.',
        ],
    ],

    'forgot_password' => [
        'email_not_found' => 'The selected email does not exist in our system.',
        'email_not_admin_or_staff' => 'The selected email does not belong to an admin or staff member.',
        'status' => [
            'success' => 'Password reset email sent successfully.',
        ],
    ],

    'reset_password' => [
        'token_invalid' => 'The password reset token is invalid or does not exist.',
        'token_expired' => 'The password reset token has expired.',
        'user_not_found' => 'User not found.',
        'status' => [
            'success' => 'Your password has been reset successfully.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    'avatar_url_file' => [
        'status' => [
            'success' => 'Avatar updated successfully.',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
    'account' => [
        'status' => [
            'success' => 'Account updated successfully.',
        ],
    ],
    'change_password' => [
        'current_password_mismatch' => 'The current password does not match with your account.',
        'status' => [
            'success' => 'Password changed successfully.',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Hints / Notes
    |--------------------------------------------------------------------------
    */
    'confirm' => [
        'delete' => [
            'title' => 'Are you sure?',
            'text' => 'You will not be able to revert this!',
            'btn' => 'Yes, delete it!',
            'cancel' => 'Cancel',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */
    'user' => [
        'created' => 'User created successfully.',
        'updated' => 'User updated successfully.',
        'deleted' => 'User deleted successfully.',
        'resend_activation_success' => 'Activation email sent successfully.',
        'resend_activation_failed' => 'Failed to send activation email.',
        'please_wait_seconds' => 'Please wait :seconds seconds before trying again.',
        'activation' => [
            'invalid_link' => 'The activation link is invalid.',
            'expired_link' => 'The activation link has expired.',
            'success' => 'Your account has been activated successfully.',
            'already_active' => 'Your account is already active.',
        ],
    ],
    'measurement' => [
        'create_success' => 'Measurement recorded successfully!',
        'update_success' => 'Measurement updated successfully!',
        'delete_success' => 'Measurement deleted successfully!',
    ],
    'import' => [
        'success' => 'Data imported successfully.',
        'failed' => 'Data import failed. Please check your file format.',
        'user_pending' => 'Cannot import data for users in pending activation status.',
    ],
    'role' => [
        'created' => 'Role created successfully.',
        'updated' => 'Role updated successfully.',
        'deleted' => 'Role deleted successfully.',
        'delete_admin_denied' => 'The Admin role cannot be deleted.',
        'has_users' => 'This role cannot be deleted because it is assigned to users.',
    ],
    'contest_created_successfully' => 'Contest created successfully.',
    'contest_updated_successfully' => 'Contest updated successfully.',
    'contest_deleted_successfully' => 'Contest deleted successfully.',
    'steps_imported_successfully' => 'Steps imported successfully.',
    'no_active_contests_found' => 'No active contests found.',
    'contest_not_active' => 'This contest is not currently active.',
    'user_not_joined_contest' => 'You have not joined this contest.',
    'invalid_import_dates' => 'The imported dates must fall within the contest start and end dates.',
    'contest_detail_not_updatable' => 'This contest record cannot be updated because it is already completed or cancelled.',
];
