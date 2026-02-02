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
    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */
    'reset_password' => [
        'token_invalid' => 'The password reset token is invalid or does not exist.',
        'token_expired' => 'The password reset token has expired.',
        'user_not_found' => 'User not found.',
        'status' => [
            'success' => 'Your password has been reset successfully.',
        ],
    ],
];
