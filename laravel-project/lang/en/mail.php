<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    'forgot_password' => [
        'title' => 'Password Reset Request',
        'subject' => 'Password Reset Request',
        'preheader' => 'You are receiving this email because we received a password reset request for your account.',
        'header' => 'PASSWORD RESET REQUEST',
        'greeting' => 'Hello, :name',
        'intro' => 'You are receiving this email because we received a password reset request for your account.',
        'request_details' => 'Request Details:',
        'username' => 'Username',
        'email' => 'Email',
        'requested_at' => 'Requested At',
        'expires_in' => 'Expires In',
        'btn_reset_password' => 'Reset Password',
        'reset_expire_note' => 'This password reset link will expire in :count minutes.',
        'reset_ignore_note' => 'If you did not request a password reset, no further action is required.',
        'fallback_text' => 'If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:',
        'security_tip_title' => 'Security Tip:',
        'reset_security_tip_body' => 'If you did not request a password reset, please secure your account immediately.',
        'email_footer_reset_reason' => 'You are receiving this email because we received a password reset request for your account.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activation
    |--------------------------------------------------------------------------
    */
    'activation' => [
        'title' => 'Activate Your Account',
        'subject' => 'Activate Your Account',
        'preheader' => 'Welcome to our platform! Please activate your account to get started.',
        'header' => 'ACTIVATE YOUR ACCOUNT',
        'greeting' => 'Hello, :name',
        'intro' => 'Welcome! Please click the button below to activate your account and complete your registration.',
        'reg_details' => 'Registration Details:',
        'username' => 'Username',
        'email' => 'Email',
        'requested_at' => 'Requested At',
        'expires_in' => 'Expires In',
        'btn_activate' => 'Activate Account',
        'expire_note' => 'This activation link will expire in :count minutes.',
        'ignore_note' => 'If you didn\'t receive this email by mistake, no further action is required.',
        'fallback_text' => 'If you\'re having trouble clicking the "Activate Account" button, copy and paste the URL below into your web browser:',
        'security_tip_title' => 'Security Tip:',
        'security_tip_body' => 'Never share your activation link with anyone else.',
        'footer_reason' => 'You are receiving this email because an account was created using this email address.',
    ],

    'email_website' => 'Website',
    'email_support' => 'Support',
    'contest_result' => [
        'title' => 'Contest Result',
        'subject' => 'Your Contest Result',
        'preheader' => 'Congratulations! Your contest ranking result is ready.',
        'header' => 'CONTEST RESULT',
        'greeting' => 'Hello, :name',
        'intro' => 'The contest has been finalized. Here is your result!',
        'contest_details' => 'Contest Details',
        'contest_name' => 'Contest Name',
        'description' => 'Description',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'your_result' => 'Your Result',
        'ranking_position' => 'Ranking Position',
        'reward_points' => 'Reward Points',
        'total_steps' => 'Total Steps',
        'start_at' => 'Start At',
        'end_at' => 'End At',
        'duration' => 'Duration',
        'joined_at' => 'Joined At',
        'rank_label' => 'Rank #:rank',
        'not_ranked' => 'Not Ranked',
        'no_reward' => 'None',
        'congrats_message' => 'Congratulations on making it to the top! Keep up the great work!',
        'passed_target_message' => 'Congratulations on completing the contest goal! Although you didn\'t make it to the top rewards this time, your effort is highly appreciated.',
        'try_again_message' => 'Unfortunately, you didn\'t meet the target for this contest. Don\'t give up, keep practicing for the next ones!',
        'note_title' => 'Note:',
        'note_body' => 'Reward points have been calculated based on your ranking position. Please check your account for the updated balance.',
        'footer_reason' => 'You are receiving this email because you participated in a contest on our platform.',
    ],
];
