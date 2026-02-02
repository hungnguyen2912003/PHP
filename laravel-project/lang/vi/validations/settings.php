<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Profile Settings Validation Messages
    |--------------------------------------------------------------------------
    */
    'fullname' => [
        'required' => 'Họ và tên là bắt buộc.',
        'string' => 'Họ và tên phải là chuỗi ký tự.',
        'max' => 'Họ và tên không được vượt quá 255 ký tự.',
    ],

    'date_of_birth' => [
        'date' => 'Vui lòng nhập ngày sinh hợp lệ.',
        'before_or_equal' => 'Ngày sinh phải là ngày hiện tại hoặc trước đó.',
    ],

    'gender' => [
        'in' => 'Giới tính không hợp lệ.',
    ],

    'phone' => [
        'regex' => 'Số điện thoại không hợp lệ.',
        'unique' => 'Số điện thoại này đã được sử dụng.',
    ],

    'address' => [
        'string' => 'Địa chỉ phải là chuỗi ký tự.',
        'max' => 'Địa chỉ không được vượt quá 255 ký tự.',
    ],

    'bio' => [
        'string' => 'Tiểu sử phải là chuỗi ký tự.',
        'max' => 'Tiểu sử không được vượt quá 1000 ký tự.',
    ],
    /*
    |--------------------------------------------------------------------------
    | Change Password Validation Messages
    |--------------------------------------------------------------------------
    */
    'current_password' => [
        'required' => 'Mật khẩu hiện tại là bắt buộc.',
    ],
    'new_password' => [
        'required' => 'Mật khẩu mới là bắt buộc.',
        'min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
    ],
    'new_password_confirmation' => [
        'required' => 'Xác nhận mật khẩu mới là bắt buộc.',
        'same' => 'Xác nhận mật khẩu mới phải khớp với mật khẩu mới.',
    ],
];
