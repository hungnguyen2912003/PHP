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
    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */
    'reset_password' => [
        'token_invalid' => 'Mã đặt lại mật khẩu không tồn tại hoặc không hợp lệ.',
        'token_expired' => 'Mã đặt lại mật khẩu đã hết hạn.',
        'user_not_found' => 'Người dùng không tồn tại.',
        'status' => [
            'success' => 'Mật khẩu của bạn đã được đặt lại thành công.',
        ],
    ],
];
