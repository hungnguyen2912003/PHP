<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
    'login' => [
        'account_not_found' => 'Account not found.',
        'no_admin_permission'=> 'You do not have admin access.',
        'invalid_credentials' => 'Invalid login credentials.',
        'status' => [
            'success' => 'Login successful.',
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    'logout' => [
        'status' => [
            'success' => 'Logout successful.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    'forgot_password' => [
        'email_not_found' => 'The selected email does not exist in our system.',
        'email_not_admin_or_staff' => 'The selected email does not belong to an admin or staff member.',
        'status' => [
            'success' => 'Password reset email sent successfully.',
        ],
    ],


];
