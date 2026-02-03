<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth
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

    'logout' => [
        'status' => [
            'success' => 'Đăng xuất thành công.',
        ],
    ],

    'forgot_password' => [
        'email_not_found' => 'Email được gửi không tồn tại trong hệ thống của chúng tôi.',
        'email_not_admin_or_staff' => 'Email được gửi không thuộc về quản trị viên hoặc nhân viên.',
        'status' => [
            'success' => 'Email đặt lại mật khẩu đã được gửi thành công.',
        ],
    ],

    'reset_password' => [
        'token_invalid' => 'Mã đặt lại mật khẩu không tồn tại hoặc không hợp lệ.',
        'token_expired' => 'Mã đặt lại mật khẩu đã hết hạn.',
        'user_not_found' => 'Người dùng không tồn tại.',
        'status' => [
            'success' => 'Mật khẩu của bạn đã được đặt lại thành công.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    'avatar_url_file' => [
        'status' => [
            'success' => 'Ảnh đại diện đã được cập nhật thành công.',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
    'account' => [
        'status' => [
            'success' => 'Cập nhật tài khoản thành công.',
        ],
    ],
    'change_password' => [
        'current_password_mismatch' => 'Mật khẩu hiện tại không khớp với tài khoản của bạn.',
        'status' => [
            'success' => 'Đổi mật khẩu thành công.',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Hints / Notes
    |--------------------------------------------------------------------------
    */
    'hint' => [
        'password_min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
    ],
];
