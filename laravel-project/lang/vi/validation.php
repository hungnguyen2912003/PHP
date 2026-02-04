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
        'exists' => 'Email được chọn không hợp lệ.',
    ],
    'username' => [
        'required' => 'Tên đăng nhập là bắt buộc.',
        'exists' => 'Tên đăng nhập được chọn không hợp lệ.',
        'unique' => 'Tên đăng nhập đã được sử dụng.',
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
        'max' => 'Kích thước ảnh đại diện không được vượt quá 2MB.',
    ],

    'bio' => [
        'string' => 'Tiểu sử phải là chuỗi ký tự.',
        'max' => 'Tiểu sử không được vượt quá 1000 ký tự.',
    ],
    'notes' => [
        'string' => 'Ghi chú phải là chuỗi ký tự.',
        'max' => 'Ghi chú không được vượt quá 1000 ký tự.',
    ],
    'weight' => [
        'required' => 'Cân nặng là bắt buộc.',
        'numeric' => 'Cân nặng phải là một con số.',
        'min' => 'Cân nặng không được nhỏ hơn :min.',
    ],
    'height' => [
        'required' => 'Chiều cao là bắt buộc.',
        'numeric' => 'Chiều cao phải là một con số.',
        'min' => 'Chiều cao không được nhỏ hơn :min.',
    ],
    'recorded_at' => [
        'required' => 'Thời gian ghi nhận là bắt buộc.',
        'date' => 'Thời gian ghi nhận không hợp lệ.',
        'before_or_equal' => 'Thời gian ghi nhận không được vượt quá hiện tại.',
    ],
    'attachment' => [
        'file' => 'Tệp đính kèm không hợp lệ.',
        'image' => 'Tệp đính kèm phải là hình ảnh.',
        'max' => 'Tệp đính kèm không được vượt quá 2MB.',
    ],
    'import' => [
        'type' => [
            'required' => 'Loại nhập dữ liệu là bắt buộc.',
            'in' => 'Loại nhập dữ liệu không hợp lệ.',
        ],
        'file' => [
            'required' => 'Tệp là bắt buộc.',
            'mimes' => 'Tệp phải là một tệp loại: xlsx, xls, csv.',
            'max' => 'Kích thước tệp phải nhỏ hơn 2MB.',
        ],
    ],
];
