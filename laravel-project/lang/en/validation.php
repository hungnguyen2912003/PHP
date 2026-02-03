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

    'current_password' => [
        'required' => 'Current password is required.',
    ],

    'new_password' => [
        'required' => 'New password is required.',
        'min' => 'New password must be at least :min characters.',
    ],

    'new_password_confirmation' => [
        'required' => 'New password confirmation is required.',
        'same' => 'New password confirmation must match the new password.',
    ],

    'email' => [
        'required' => 'Email is required.',
        'email' => 'Email must be a valid email address.',
        'max' => 'Email must not exceed :max characters.',
        'unique' => 'Email has already been taken.',
        'exists' => 'The selected email is invalid.',
    ],
    'username' => [
        'required' => 'Username is required.',
        'exists' => 'The selected username is invalid.',
        'unique' => 'Username has already been taken.',
    ],

    'fullname' => [
        'required' => 'Full name is required.',
        'max' => 'Full name must not exceed 255 characters.',
        'string' => 'Full name must be a string.',
    ],

    'role_id' => [
        'required' => 'Role is required.',
        'exists' => 'Selected role is invalid.',
    ],

    'status' => [
        'required' => 'Status is required.',
        'in' => 'Selected status is invalid.',
    ],

    'phone' => [
        'regex' => 'Phone number format is invalid.',
        'unique' => 'Phone number has already been taken.',
        'max' => 'Phone number must not exceed 20 characters.',
    ],

    'address' => [
        'string' => 'Address must be a string.',
        'max' => 'Address must not exceed 255 characters.',
    ],

    'gender' => [
        'in' => 'Selected gender is invalid.',
    ],

    'date_of_birth' => [
        'date' => 'Date of birth must be a valid date.',
        'before_or_equal' => 'Date of birth must be today or earlier.',
    ],

    'avatar_url_file' => [
        'required' => 'Avatar image is required.',
        'image' => 'Avatar image must be an image file.',
        'mimes' => 'Avatar image must be a file of type: jpeg, png, jpg, gif.',
        'max' => 'Avatar image size must be less than 2MB.',
    ],

    'bio' => [
        'string' => 'Bio must be a string.',
        'max' => 'Bio must not exceed 1000 characters.',
    ],
];
