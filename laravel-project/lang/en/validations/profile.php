<?php

return [
    'avatar_url_file' => [
        'required' => 'Avatar image is required.',
        'image' => 'Avatar image must be an image file.',
        'mimes' => 'Avatar image must be a file of type: jpeg, png, jpg, gif.',
        'max' => 'Avatar image size must be less than 2MB.',
    ],
];
