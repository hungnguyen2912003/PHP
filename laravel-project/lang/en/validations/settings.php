<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Profile Settings Validation Messages
    |--------------------------------------------------------------------------
    */
    'fullname' => [
        'required' => 'Full name is required.',
        'string' => 'Full name must be a string.',
        'max' => 'Full name must not exceed 255 characters.',
    ],

    'date_of_birth' => [
        'date' => 'Please enter a valid date of birth.',
        'before_or_equal' => 'Date of birth must be today or earlier.',
    ],

    'gender' => [
        'in' => 'Please select a valid gender.',
    ],

    'phone' => [
        'regex' => 'Please enter a valid phone number.',
        'unique' => 'This phone number is already in use.',
    ],

    'address' => [
        'string' => 'Address must be a string.',
        'max' => 'Address must not exceed 255 characters.',
    ],

    'bio' => [
        'string' => 'Bio must be a string.',
        'max' => 'Bio must not exceed 1000 characters.',
    ],
    /*
    |--------------------------------------------------------------------------
    | Change Password Validation Messages
    |--------------------------------------------------------------------------
    */
    'current_password' => [
        'required' => 'Current password is required.',
    ],
    'new_password' => [
        'required' => 'New password is required.',
        'min' => 'New password must be at least 6 characters.',
    ],
    'new_password_confirmation' => [
        'required' => 'New password confirmation is required.',
        'same' => 'New password confirmation must match the new password.',
    ],
];