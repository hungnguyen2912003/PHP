<?php

return [
    'fullname' => [
        'required' => 'Full name is required.',
        'max' => 'Full name must not exceed 255 characters.',
        'string' => 'Full name must be a string.',
    ],
    'email' => [
        'required' => 'Email is required.',
        'email' => 'Email must be a valid email address.',
        'unique' => 'Email has already been taken.',
    ],
    'role_id' => [
        'required' => 'Role is required.',
        'exists' => 'Selected role is invalid.',
    ],
    'password' => [
        'required' => 'Password is required.',
        'min' => 'Password must be at least :min characters.',
    ],
    'status' => [
        'required' => 'Status is required.',
        'in' => 'Selected status is invalid.',
    ],
    'phone' => [
        'max' => 'Phone number must not exceed 20 characters.',
    ],
    'address' => [
        'max' => 'Address must not exceed 255 characters.',
    ],
    'gender' => [
        'in' => 'Selected gender is invalid.',
    ],
    'date_of_birth' => [
        'date' => 'Date of birth must be a valid date.',
    ],
];
