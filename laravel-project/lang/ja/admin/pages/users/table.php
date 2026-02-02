<?php

return [
    'columns' => [
        'stt' => '番号',
        'full_name' => '氏名',
        'date_of_birth' => '生年月日',
        'gender' => '性別',
        'email' => 'メールアドレス',
        'phone' => '電話番号',
        'address' => '住所',
        'role' => '役割',
        'status' => 'ステータス',
        'action' => '操作',
    ],
    'values' => [
        'gender' => [
            'male' => '男性',
            'female' => '女性',
            'other' => 'その他',
        ],
        'not_available' => '利用不可',
        'role' => [
            'admin' => '管理者',
            'user' => 'ユーザー',
            'staff' => 'スタッフ',
        ],
        'status' => [
            'active' => 'アクティブ',
            'pending' => '保留中',
            'banned' => '禁止',
            'deleted' => '削除済み',
        ],
    ],
];
