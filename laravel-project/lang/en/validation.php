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
    'name' => [
        'required' => 'The :attribute is required.',
        'unique' => 'The :attribute has already been taken.',
        'string' => 'The :attribute must be a string.',
        'max' => 'The :attribute must not exceed 255 characters.',
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
    'notes' => [
        'string' => 'Notes must be a string.',
        'max' => 'Notes must not exceed 1000 characters.',
    ],
    'weight' => [
        'required' => 'Weight is required.',
        'numeric' => 'Weight must be a number.',
        'min' => 'Weight must be at least :min.',
    ],
    'height' => [
        'required' => 'Height is required.',
        'numeric' => 'Height must be a number.',
        'min' => 'Height must be at least :min.',
    ],
    'recorded_at' => [
        'required' => 'Recorded at is required.',
        'date' => 'Recorded at must be a valid date.',
        'before_or_equal' => 'Recorded at must be today or earlier.',
    ],
    'attachment' => [
        'file' => 'Attachment must be a file.',
        'image' => 'Attachment must be an image.',
        'max' => 'Attachment size must be less than 2MB.',
    ],
    'import' => [
        'type' => [
            'required' => 'Import type is required.',
            'in' => 'Import type is invalid.',
        ],
        'file' => [
            'required' => 'File is required.',
            'mimes' => 'File must be a file of type: xlsx, xls, csv.',
            'max' => 'File size must be less than 2MB.',
        ],
    ],
    'start_date' => [
        'required' => 'Start date is required.',
        'date' => 'Start date must be a valid date.',
        'after_or_equal' => 'Start date must be today or in the future.',
    ],
    'end_date' => [
        'required' => 'End date is required.',
        'date' => 'End date must be a valid date.',
        'after_or_equal' => 'End date must be greater than or equal to start date.',
    ],
];
