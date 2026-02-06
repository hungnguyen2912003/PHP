<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    'login' => [
        'account_not_found' => 'Tài khoản không tồn tại.',
        'no_admin_permission' => 'Bạn không có quyền truy cập quản trị.',
        'invalid_credentials' => 'Thông tin đăng nhập không hợp lệ.',
        'status' => [
            'success' => 'Đăng nhập thành công.',
        ]
    ],

    'register' => [
        'success' => 'Đăng ký tài khoản thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.',
        'user_exists' => 'Email hoặc tên đăng nhập đã được sử dụng.',
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

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */
    'user' => [
        'created' => 'Tạo người dùng thành công.',
        'updated' => 'Cập nhật người dùng thành công.',
        'deleted' => 'Xóa người dùng thành công.',
        'resend_activation_success' => 'Gửi email kích hoạt thành công.',
        'resend_activation_failed' => 'Gửi email kích hoạt thất bại.',
        'please_wait_seconds' => 'Vui lòng đợi :seconds giây trước khi thử lại.',
        'activation' => [
            'invalid_link' => 'Liên kết kích hoạt không hợp lệ.',
            'expired_link' => 'Liên kết kích hoạt đã hết hạn.',
            'success' => 'Tài khoản của bạn đã được kích hoạt thành công.',
            'already_active' => 'Tài khoản của bạn đã được kích hoạt.',
        ],
    ],
    'measurement' => [
        'create_success' => 'Ghi nhận chỉ số cơ thể thành công!',
        'update_success' => 'Cập nhật chỉ số cơ thể thành công!',
        'delete_success' => 'Xóa chỉ số cơ thể thành công!',
    ],
    'import' => [
        'success' => 'Nhập dữ liệu thành công.',
        'failed' => 'Nhập dữ liệu thất bại. Vui lòng kiểm tra định dạng tệp của bạn.',
    ],
    'role' => [
        'created' => 'Vai trò đã được tạo thành công.',
        'updated' => 'Vai trò đã được cập nhật thành công.',
        'deleted' => 'Vai trò đã được xóa thành công.',
        'delete_admin_denied' => 'Không thể xóa vai trò Admin.',
        'has_users' => 'Vai trò này không thể xóa vì đang được gán cho người dùng.',
    ],
];
