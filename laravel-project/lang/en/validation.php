<?php

return [
    'login' => [
        'required' => 'The login field is required.',
        'min' => 'The login must be at least :min characters.',
        'max' => 'The login may not be greater than :max characters.',
    ],

    'password' => [
        'required' => 'The password field is required.',
        'min' => 'The password must be at least :min characters.',
        'max' => 'The password may not be greater than :max characters.',
    ],

    'email' => [
        'required' => 'The email field is required.',
        'valid' => 'The email must be a valid email address.',
        'max' => 'The email may not be greater than :max characters.',
    ],
];
