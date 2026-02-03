<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    'forgot_password' => [
        'title' => 'Password Reset Request',
        'subject' => 'Password Reset Request',
        'preheader' => 'You are receiving this email because we received a password reset request for your account.',
        'header' => 'PASSWORD RESET REQUEST',
        'greeting' => 'Hello, :name',
        'intro' => 'You are receiving this email because we received a password reset request for your account.',
        'request_details' => 'You are receiving this email because we received a password reset request for your account. Here are the details of the request',
        'username' => 'Username',
        'email' => 'Email',
        'requested_at' => 'Requested At',
        'expires_in' => 'Expires In',
        'btn_reset_password' => 'Reset Password',
        'reset_expire_note' => 'This password reset link will expire in :count minutes.',
        'reset_ignore_note' => 'If you did not request a password reset, no further action is required.',
        'fallback_text' => 'If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:',
        'security_tip_title' => 'Security Tip:',
        'reset_security_tip_body' => 'If you did not request a password reset, please secure your account immediately.',
        'email_footer_reset_reason' => 'You are receiving this email because we received a password reset request for your account.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activation
    |--------------------------------------------------------------------------
    */
    'activation' => [
        'title' => 'Activate Your Account',
        'subject' => 'Activate Your Account',
        'preheader' => 'Welcome to our platform! Please activate your account to get started.',
        'header' => 'ACTIVATE YOUR ACCOUNT',
        'greeting' => 'Hello, :name',
        'intro' => 'Welcome! Please click the button below to activate your account and complete your registration.',
        'reg_details' => 'Registration Details:',
        'username' => 'Username',
        'email' => 'Email',
        'requested_at' => 'Requested At',
        'expires_in' => 'Expires In',
        'btn_activate' => 'Activate Account',
        'expire_note' => 'This activation link will expire in :count minutes.',
        'ignore_note' => 'If you didn\'t receive this email by mistake, no further action is required.',
        'fallback_text' => 'If you\'re having trouble clicking the "Activate Account" button, copy and paste the URL below into your web browser:',
        'security_tip_title' => 'Security Tip:',
        'security_tip_body' => 'Never share your activation link with anyone else.',
        'footer_reason' => 'You are receiving this email because an account was created using this email address.',
    ],

    'email_website' => 'Website',
    'email_support' => 'Support',
];
