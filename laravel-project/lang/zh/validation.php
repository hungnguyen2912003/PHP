<?php

return [
    'login' => [
        'required' => '登录是必须的。',
        'min' => '登录名必须至少 :min 个字符。',
        'max' => '登录名不能超过 :max 个字符。',
    ],
    'password' => [
        'required' => '密码是必须的。',
        'min' => '密码必须至少 :min 个字符。',
        'max' => '密码不能超过 :max 个字符。',
    ],
    'password_confirmation' => [
        'required' => '必须确认密码。',
        'same' => '密码确认必须与密码匹配。',
    ],
    'current_password' => [
        'required' => '当前密码是必须的。',
    ],
    'new_password' => [
        'required' => '新密码是必须的。',
        'min' => '新密码必须至少 :min 个字符。',
    ],
    'new_password_confirmation' => [
        'required' => '必须确认新密码。',
        'same' => '新密码确认必须与新密码匹配。',
    ],
    'email' => [
        'required' => '电子邮件是必须的。',
        'email' => '电子邮件必须是有效的电子邮件地址。',
        'max' => '电子邮件不能超过 :max 个字符。',
        'unique' => '电子邮件已被占用。',
        'exists' => '所选电子邮件无效。',
    ],
    'username' => [
        'required' => '用户名是必须的。',
        'exists' => '所选用户名无效。',
        'unique' => '用户名已被占用。',
    ],
    'fullname' => [
        'required' => '全名是必须的。',
        'max' => '全名不能超过 255 个字符。',
        'string' => '全名必须是字符串。',
    ],
    'name' => [
        'required' => ':attribute 是必须的。',
        'unique' => ':attribute 已被占用。',
        'string' => ':attribute 必须是字符串。',
        'max' => ':attribute 不能超过 255 个字符。',
    ],
    'role_id' => [
        'required' => '角色是必须的。',
        'exists' => '选择的角色无效。',
    ],
    'status' => [
        'required' => '状态是必须的。',
        'in' => '选择的状态无效。',
    ],
    'phone' => [
        'regex' => '电话号码格式无效。',
        'unique' => '电话号码已被占用。',
        'max' => '电话号码不能超过 20 个字符。',
    ],
    'address' => [
        'string' => '地址必须是字符串。',
        'max' => '地址不能超过 255 个字符。',
    ],
    'gender' => [
        'in' => '选择的性别无效。',
    ],
    'date_of_birth' => [
        'date' => '出生日期必须是有效日期。',
        'before_or_equal' => '出生日期必须是今天或更早。',
    ],
    'avatar_url_file' => [
        'required' => '头像是必须的。',
        'image' => '头像必须是图像文件。',
        'mimes' => '头像必须是类型为：jpeg、png、jpg、gif 的文件。',
        'max' => '头像大小必须小于 2MB。',
    ],
    'bio' => [
        'string' => '个人简介必须是字符串。',
        'max' => '个人简介不能超过 1000 个字符。',
    ],
    'notes' => [
        'string' => '备注必须是字符串。',
        'max' => '备注不能超过 1000 个字符。',
    ],
    'weight' => [
        'required' => '体重是必须的。',
        'numeric' => '体重必须是一个数字。',
        'min' => '体重必须至少为 :min。',
    ],
    'height' => [
        'required' => '身高是必须的。',
        'numeric' => '身高必须是一个数字。',
        'min' => '身高必须至少为 :min。',
    ],
    'recorded_at' => [
        'required' => '记录时间是必须的。',
        'date' => '记录时间必须是有效日期。',
        'before_or_equal' => '记录时间必须是今天或更早。',
    ],
    'attachment' => [
        'file' => '附件必须是一个文件。',
        'image' => '附件必须是一张图片。',
        'max' => '附件大小必须小于 2MB。',
    ],
    'import' => [
        'type' => [
            'required' => '导入类型是必须的。',
            'in' => '导入类型无效。',
        ],
        'file' => [
            'required' => '文件是必须的。',
            'mimes' => '文件必须是类型为：xlsx、xls、csv 的文件。',
            'max' => '文件大小必须小于 2MB。',
        ],
    ],
    'start_date' => [
        'required' => '开始日期是必须的。',
        'date' => '开始日期必须是有效日期。',
        'after_or_equal' => '开始日期必须是今天或将来。',
    ],
    'end_date' => [
        'required' => '结束日期是必须的。',
        'date' => '结束日期必须是有效日期。',
        'after_or_equal' => '结束日期必须大于或等于开始日期。',
    ],
];
