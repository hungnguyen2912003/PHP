<?php

return [
    'login' => [
        'account_not_found' => '未找到帐户。',
        'no_admin_permission' => '您没有管理员访问权限。',
        'invalid_credentials' => '登录凭据无效。',
        'status' => [
            'success' => '登录成功。',
        ]
    ],
    'register' => [
        'success' => '注册成功！请检查您的电子邮件以激活您的帐户。',
        'user_exists' => '电子邮件或用户名已被占用。',
    ],
    'logout' => [
        'status' => [
            'success' => '注销成功。',
        ],
    ],
    'forgot_password' => [
        'email_not_found' => '所选电子邮件在我们的系统中不存在。',
        'email_not_admin_or_staff' => '所选电子邮件不属于管理员或员工。',
        'status' => [
            'success' => '密码重置电子邮件已成功发送。',
        ],
    ],
    'reset_password' => [
        'token_invalid' => '密码重置令牌无效或不存在。',
        'token_expired' => '密码重置令牌已过期。',
        'user_not_found' => '未找到用户。',
        'status' => [
            'success' => '您的密码已成功重置。',
        ],
    ],
    'avatar_url_file' => [
        'status' => [
            'success' => '头像更新成功。',
        ],
    ],
    'account' => [
        'status' => [
            'success' => '帐户更新成功。',
        ],
    ],
    'change_password' => [
        'current_password_mismatch' => '当前密码与您的帐户不匹配。',
        'status' => [
            'success' => '密码更改成功。',
        ],
    ],
    'confirm' => [
        'delete' => [
            'title' => '您确定吗？',
            'text' => '您将无法恢复此操作！',
            'btn' => '是的，删除它！',
            'cancel' => '取消',
        ],
    ],
    'user' => [
        'created' => '用户创建成功。',
        'updated' => '用户更新成功。',
        'deleted' => '用户删除成功。',
        'resend_activation_success' => '激活电子邮件已成功发送。',
        'resend_activation_failed' => '发送激活电子邮件失败。',
        'please_wait_seconds' => '请等待 :seconds 秒后再试。',
        'activation' => [
            'invalid_link' => '激活链接无效。',
            'expired_link' => '激活链接已过期。',
            'success' => '您的帐户已成功激活。',
            'already_active' => '您的帐户已激活。',
        ],
    ],
    'measurement' => [
        'create_success' => '测量已成功记录！',
        'update_success' => '测量已成功更新！',
        'delete_success' => '测量已成功删除！',
    ],
    'import' => [
        'success' => '数据导入成功。',
        'failed' => '数据导入失败。请检查您的文件格式。',
        'user_pending' => '无法为处于待激活状态的用户导入数据。',
    ],
    'role' => [
        'created' => '角色创建成功。',
        'updated' => '角色更新成功。',
        'deleted' => '角色删除成功。',
        'delete_admin_denied' => '不能删除系统管理员角色。',
        'has_users' => '无法删除此角色，因为系统已有用户与此角色关联。',
    ],
    'contest_created_successfully' => '比赛创建成功。',
    'contest_updated_successfully' => '比赛更新成功。',
    'contest_deleted_successfully' => '比赛删除成功。',
];
