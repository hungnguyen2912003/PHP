<?php

return [
    'columns' => [
        'stt' => 'STT',
        'full_name' => 'Full Name',
        'date_of_birth' => 'Date of Birth',
        'gender' => 'Gender',
        'email' => 'Email',
        'phone' => 'Phone',
        'address' => 'Address',
        'role' => 'Role',
        'status' => 'Status',
        'action' => 'Action',
    ],
    'values' => [
        'gender' => [
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
        ],
        'not_available' => 'N/A',
        'role' => [
            'admin' => 'Admin',
            'user' => 'User',
            'staff' => 'Staff',
        ],
        'status' => [
            'active' => 'Active',
            'pending' => 'Pending',
            'banned' => 'Banned',
            'deleted' => 'Deleted',
        ],
    ],
];
