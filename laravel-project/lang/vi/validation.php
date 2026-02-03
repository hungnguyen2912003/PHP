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

    'password_confirmation' => [
        'required' => 'Trường xác nhận mật khẩu là bắt buộc.',
        'same' => 'Xác nhận mật khẩu và mật khẩu phải khớp nhau.',
    ],

    'current_password' => [
        'required' => 'Mật khẩu hiện tại là bắt buộc.',
    ],

    'new_password' => [
        'required' => 'Mật khẩu mới là bắt buộc.',
        'min' => 'Mật khẩu mới phải có ít nhất :min ký tự.',
    ],

    'new_password_confirmation' => [
        'required' => 'Xác nhận mật khẩu mới là bắt buộc.',
        'same' => 'Xác nhận mật khẩu mới và mật khẩu mới phải khớp nhau.',
    ],

    'email' => [
        'required' => 'Trường email là bắt buộc.',
        'email' => 'Email phải là một địa chỉ email hợp lệ.',
        'max' => 'Email không được lớn hơn :max ký tự.',
        'unique' => 'Email đã được sử dụng.',
    ],

    'fullname' => [
        'required' => 'Họ và tên là bắt buộc.',
        'max' => 'Họ và tên không được vượt quá 255 ký tự.',
        'string' => 'Họ và tên phải là một chuỗi ký tự.',
    ],

    'role_id' => [
        'required' => 'Vai trò là bắt buộc.',
        'exists' => 'Vai trò được chọn không hợp lệ.',
    ],

    'status' => [
        'required' => 'Trạng thái là bắt buộc.',
        'in' => 'Trạng thái được chọn không hợp lệ.',
    ],

    'phone' => [
        'regex' => 'Số điện thoại không hợp lệ.',
        'unique' => 'Số điện thoại này đã được sử dụng.',
        'max' => 'Số điện thoại không được vượt quá 20 ký tự.',
    ],

    'address' => [
        'string' => 'Địa chỉ phải là chuỗi ký tự.',
        'max' => 'Địa chỉ không được vượt quá 255 ký tự.',
    ],
    'gender' => [
        'in' => 'Giới tính được chọn không hợp lệ.',
    ],
    'date_of_birth' => [
        'date' => 'Ngày sinh phải là một ngày hợp lệ.',
        'before_or_equal' => 'Ngày sinh phải là ngày hiện tại hoặc trước đó.',
    ],

    'avatar_url_file' => [
        'required' => 'Ảnh đại diện là bắt buộc.',
        'image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
        'mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
        'max' => 'Kích thước ảnh đại diện phải nhỏ hơn 2MB.',
    ],

    'bio' => [
        'string' => 'Tiểu sử phải là chuỗi ký tự.',
        'max' => 'Tiểu sử không được vượt quá 1000 ký tự.',
    ],
];
