<?php

return [
    'login' => [
        'required' => 'Trường đăng nhập là bắt buộc.',
        'min' => 'Đăng nhập phải có ít nhất :min ký tự.',
        'max' => 'Đăng nhập không được lớn hơn :max ký tự.',
    ],

    'password' => [
        'required' => 'Trường mật khẩu là bắt buộc.',
        'min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        'max' => 'Mật khẩu không được lớn hơn :max ký tự.',
    ],

    'email' => [
        'required' => 'Trường email là bắt buộc.',
        'valid' => 'Email phải là một địa chỉ email hợp lệ.',
        'max' => 'Email không được lớn hơn :max ký tự.',
    ],
];
