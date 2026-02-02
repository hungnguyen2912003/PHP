<?php

return [
    'login' => [
        'required' => 'Login is required.',
        'min' => 'Login must be at least :min characters.',
        'max' => 'Login must not exceed :max characters.',
    ],

    'password' => [
        'required' => 'Password is required.',
        'min' => 'Password must be at least :min characters.',
        'max' => 'Password must not exceed :max characters.',
    ],

    'password_confirmation' => [
        'required' => 'Password confirmation is required.',
        'same' => 'Password confirmation must match the password.',
    ],

    'email' => [
        'required' => 'Email is required.',
        'valid' => 'Email must be a valid email address.',
        'max' => 'Email must not exceed :max characters.',
    ],
];
