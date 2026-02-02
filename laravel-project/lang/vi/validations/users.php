<?php

return [
    'fullname' => [
        'required' => 'Họ và tên là bắt buộc.',
        'max' => 'Họ và tên không được vượt quá 255 ký tự.',
        'string' => 'Họ và tên phải là một chuỗi ký tự.',
    ],
    'email' => [
        'required' => 'Email là bắt buộc.',
        'email' => 'Email phải là một địa chỉ email hợp lệ.',
        'unique' => 'Email đã được sử dụng.',
    ],
    'role_id' => [
        'required' => 'Vai trò là bắt buộc.',
        'exists' => 'Vai trò được chọn không hợp lệ.',
    ],
    'password' => [
        'required' => 'Mật khẩu là bắt buộc.',
        'min' => 'Mật khẩu phải có ít nhất :min ký tự.',
    ],
    'status' => [
        'required' => 'Trạng thái là bắt buộc.',
        'in' => 'Trạng thái được chọn không hợp lệ.',
    ],
    'phone' => [
        'max' => 'Số điện thoại không được vượt quá 20 ký tự.',
    ],
    'address' => [
        'max' => 'Địa chỉ không được vượt quá 255 ký tự.',
    ],
    'gender' => [
        'in' => 'Giới tính được chọn không hợp lệ.',
    ],
    'date_of_birth' => [
        'date' => 'Ngày sinh phải là một ngày hợp lệ.',
    ],
];
