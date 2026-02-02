<?php

return [
    'columns' => [
        'stt' => 'STT',
        'full_name' => 'Họ và tên',
        'date_of_birth' => 'Ngày sinh',
        'gender' => 'Giới tính',
        'email' => 'Email',
        'phone' => 'Số điện thoại',
        'address' => 'Địa chỉ',
        'role' => 'Vai trò',
        'status' => 'Trạng thái',
        'action' => 'Hành động',
    ],
    'values' => [
        'gender' => [
            'male' => 'Nam',
            'female' => 'Nữ',
            'other' => 'Khác',
        ],
        'not_available' => 'Chưa cập nhật',
        'role' => [
            'admin' => 'Quản trị viên',
            'user' => 'Người dùng',
            'staff' => 'Nhân viên',
        ],
        'status' => [
            'active' => 'Hoạt động',
            'pending' => 'Chờ duyệt',
            'banned' => 'Đã khóa',
            'deleted' => 'Đã xóa',
        ],
    ],
];
