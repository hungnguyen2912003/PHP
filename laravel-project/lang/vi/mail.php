<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    'forgot_password' => [
        'title' => 'Yêu cầu đặt lại mật khẩu',
        'subject' => 'Yêu cầu đặt lại mật khẩu',
        'header' => 'ĐẶT LẠI MẬT KHẨU',
        'preheader' => 'Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.',
        'greeting' => 'Xin chào :name,',
        'intro' => 'Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn. Nhấp vào nút bên dưới để đặt mật khẩu mới.',
        'request_details' => 'Email này được gửi vì có yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Chi tiết yêu cầu như sau:',
        'username' => 'Tên đăng nhập',
        'email' => 'Địa chỉ email',
        'requested_at' => 'Thời gian yêu cầu',
        'expires_in' => 'Hết hạn trong',
        'btn_reset_password' => 'Đặt lại mật khẩu',
        'reset_expire_note' => 'Liên kết đặt lại mật khẩu này sẽ hết hạn sau :count phút.',
        'reset_ignore_note' => 'Nếu bạn không yêu cầu đặt lại mật khẩu, bạn không cần thực hiện hành động nào cả.',
        'fallback_text' => 'Nếu bạn không thể nhấp vào nút "Đặt lại mật khẩu", hãy sao chép và dán URL sau vào trình duyệt web của bạn:',
        'security_tip_title'=> 'Mẹo bảo mật:',
        'reset_security_tip_body' => 'Nếu bạn không yêu cầu đặt lại mật khẩu, hãy bảo vệ tài khoản của bạn ngay lập tức.',
        'email_footer_reset_reason' => 'Email này được gửi vì có yêu cầu đặt lại mật khẩu cho tài khoản của bạn.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activation
    |--------------------------------------------------------------------------
    */
    'activation' => [
        'title' => 'Kích hoạt tài khoản của bạn',
        'subject' => 'Kích hoạt tài khoản của bạn',
        'preheader' => 'Chào mừng bạn đến với nền tảng của chúng tôi! Vui lòng kích hoạt tài khoản của bạn để bắt đầu.',
        'header' => 'KÍCH HOẠT TÀI KHOẢN',
        'greeting' => 'Xin chào :name,',
        'intro' => 'Chào mừng bạn! Vui lòng nhấp vào nút bên dưới để kích hoạt tài khoản và hoàn tất đăng ký.',
        'reg_details' => 'Chi tiết đăng ký:',
        'username' => 'Tên đăng nhập',
        'email' => 'Địa chỉ email',
        'requested_at' => 'Thời gian yêu cầu',
        'expires_in' => 'Hết hạn trong',
        'btn_activate' => 'Kích hoạt tài khoản',
        'expire_note' => 'Liên kết kích hoạt này sẽ hết hạn sau :count phút.',
        'ignore_note' => 'Nếu bạn nhận được email này do nhầm lẫn, bạn không cần thực hiện thêm hành động nào.',
        'fallback_text' => 'Nếu bạn không thể nhấp vào nút "Kích hoạt tài khoản", hãy sao chép và dán URL sau vào trình duyệt web của bạn:',
        'security_tip_title' => 'Mẹo bảo mật:',
        'security_tip_body' => 'Không bao giờ chia sẻ liên kết kích hoạt của bạn với bất kỳ ai khác.',
        'footer_reason' => 'Bạn nhận được email này vì một tài khoản đã được tạo bằng địa chỉ email này.',
    ],

    'email_website' => 'Trang web',
    'email_support' => 'Hỗ trợ',
    'contest_result' => [
        'title' => 'Kết quả cuộc thi',
        'subject' => 'Kết quả cuộc thi của bạn',
        'preheader' => 'Chúc mừng! Kết quả xếp hạng cuộc thi đã sẵn sàng.',
        'header' => 'KẾT QUẢ CUỘC THI',
        'greeting' => 'Xin chào :name,',
        'intro' => 'Cuộc thi đã được tổng kết. Đây là kết quả của bạn!',
        'contest_details' => 'Thông tin cuộc thi',
        'contest_name' => 'Tên cuộc thi',
        'description' => 'Mô tả',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'your_result' => 'Kết quả của bạn',
        'ranking_position' => 'Vị trí xếp hạng',
        'reward_points' => 'Điểm thưởng',
        'total_steps' => 'Tổng số bước',
        'start_at' => 'Thời gian bắt đầu',
        'end_at' => 'Thời gian kết thúc',
        'duration' => 'Thời lượng',
        'joined_at' => 'Thời gian tham gia',
        'rank_label' => 'Hạng #:rank',
        'not_ranked' => 'Không xếp hạng',
        'no_reward' => 'Không có',
        'congrats_message' => 'Chúc mừng bạn đã lọt vào top nhận thưởng! Hãy tiếp tục duy trì phong độ này nhé!',
        'passed_target_message' => 'Chúc mừng bạn đã hoàn thành mục tiêu của cuộc thi! Dù chưa lọt vào top nhận thưởng lần này, nhưng nỗ lực của bạn rất đáng ghi nhận.',
        'try_again_message' => 'Rất tiếc, bạn chưa đạt mục tiêu của cuộc thi lần này. Đừng nản lòng, hãy cố gắng hơn ở các cuộc thi tiếp theo nhé!',
        'note_title' => 'Lưu ý:',
        'note_body' => 'Điểm thưởng đã được tính dựa trên vị trí xếp hạng của bạn. Vui lòng kiểm tra tài khoản để xem số dư cập nhật.',
        'footer_reason' => 'Bạn nhận được email này vì bạn đã tham gia cuộc thi trên nền tảng của chúng tôi.',
    ],
];
