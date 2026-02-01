<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
    'login' => [
        'account_not_found' => 'Tài khoản không tồn tại.',
        'no_admin_permission'=> 'Bạn không có quyền truy cập quản trị.',
        'invalid_credentials' => 'Thông tin đăng nhập không hợp lệ.',
        'status' => [
            'success' => 'Đăng nhập thành công.',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    'logout' => [
        'status' => [
            'success' => 'Đăng xuất thành công.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    'forgot_password' => [
        'email_not_found' => 'Email được gửi không tồn tại trong hệ thống của chúng tôi.',
        'email_not_admin_or_staff' => 'Email được gửi không thuộc về quản trị viên hoặc nhân viên.',
        'status' => [
            'success' => 'Email đặt lại mật khẩu đã được gửi thành công.',
        ],
    ],
];
