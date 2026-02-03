<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="x-apple-disable-message-reformatting">
    <title>{{ __('mail.activation.title') }}</title>
</head>

<body
    style="margin:0;padding:0;background:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#111827;">
    <!-- Preheader -->
    <div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;">
        {{ __('mail.activation.preheader') }}
    </div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="padding:24px 0;border-collapse:collapse;">
    <tr>
            <td align="center" style="padding:0 16px;">

                <table role="presentation" width="640" cellspacing="0" cellpadding="0"
                    style="max-width:640px;width:100%;border-collapse:collapse;">
                    <!-- Card -->
                    <tr>
                        <td
                            style="background:#ffffff;border:1px solid rgba(17,24,39,.08);box-shadow:0 14px 40px rgba(17,24,39,.08);overflow:hidden;">

                            <!-- Header -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:22px 24px;background:linear-gradient(135deg,#111827,#1f2937);">
                                        <div
                                            style="font-size:12px;font-weight:700;color:#c7d2fe;letter-spacing:.12em;text-transform:uppercase;">
                                            {{ __('mail.activation.header') }}
                                        </div>
                                        <div style="margin-top:8px;font-size:22px;font-weight:800;color:#ffffff;">
                                            {{ __('mail.activation.greeting', ['name' => $user->fullname]) }}
                                        </div>
                                        <div style="margin-top:8px;font-size:14px;line-height:1.7;color:#d1d5db;">
                                            {{ __('mail.activation.intro') }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Body -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:24px;box-sizing:border-box;">

                                        <!-- Info -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                            style="border-collapse:collapse;background:#f9fafb;border:1px solid #e5e7eb;border-radius:14px;">
                                            <tr>
                                                <td style="padding:16px;box-sizing:border-box;">
                                                    <div style="font-size:13px;line-height:1.6;color:#6b7280;">
                                                        <div style="font-weight:700;color:#111827;margin-bottom:6px;">
                                                            {{ __('mail.activation.reg_details') }}</div>
                                                        <div><b>{{ __('mail.activation.username') }}:</b> {{ $user->username }}</div>
                                                        <div><b>{{ __('mail.activation.email') }}:</b> {{ $user->email }}</div>
                                                        <div><b>{{ __('mail.activation.requested_at') }}:</b> {{ now() }}</div>
                                                        <div><b>{{ __('mail.activation.expires_in') }}:</b> {{ $expires_in }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- CTA -->
                                        <table role="presentation" cellpadding="0" cellspacing="0"
                                            style="margin:20px auto 10px;border-collapse:collapse;">
                                            <tr>
                                                <td align="center"
                                                    style="background:linear-gradient(135deg,#2563eb,#7c3aed);border-radius:14px;">
                                                    <a href="{{ $activation_url }}"
                                                        style="display:inline-block;padding:14px 26px;font-size:15px;font-weight:800;color:#ffffff;text-decoration:none;border-radius:14px;">
                                                        {{ __('mail.activation.btn_activate') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Expire note -->
                                        <div style="margin-top:6px;font-size:13px;line-height:1.7;color:#6b7280;">
                                            {{ __('mail.activation.expire_note', ['count' => 30]) }}
                                            {{ __('mail.activation.ignore_note') }}
                                        </div>

                                        <!-- Divider -->
                                        <div style="height:1px;background:#e5e7eb;margin:22px 0;"></div>

                                        <!-- Fallback -->
                                        <div style="font-size:13px;line-height:1.7;color:#6b7280;">
                                            {{ __('mail.activation.fallback_text') }}
                                        </div>

                                        <!-- Link box -->
                                        <div style="margin-top:10px;padding:14px;background:#f9fafb;border:1px dashed #c7d2fe;border-radius:12px;
                                font-size:13px;box-sizing:border-box;max-width:100%;
                                word-break:break-word;overflow-wrap:anywhere;">
                                            🔗
                                            <a href="{{ $activation_url }}"
                                                style="color:#2563eb;font-weight:600;text-decoration:none;word-break:break-word;overflow-wrap:anywhere;">
                                                {{ $activation_url }}
                                            </a>
                                        </div>

                                        <!-- Security tip (NẰM TRONG PADDING, KHÔNG TRÀN) -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                            style="margin-top:20px;border-collapse:collapse;background:#eef2ff;border:1px solid #c7d2fe;border-radius:14px;">
                                            <tr>
                                                <td style="padding:14px;box-sizing:border-box;">
                                                    <div style="font-size:12px;line-height:1.7;color:#3730a3;">
                                                        <b>{{ __('mail.activation.security_tip_title') }}</b> {{ __('mail.activation.security_tip_body') }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <!-- Footer -->
                                <tr>
                                    <td align="center"
                                        style="padding:18px 8px 0;font-size:12px;line-height:1.6;color:#6b7280;">
                                        <div>{{ __('mail.activation.footer_reason') }}
                                        </div>
                                        <div style="margin-top:6px;">
                                            © {{ date('Y') }} {{ config('app.name') }} •
                                            <a href="/"
                                                style="color:#2563eb;text-decoration:none;font-weight:700;">{{ __('mail.email_website') }}</a>
                                            •
                                            <a href="/"
                                                style="color:#2563eb;text-decoration:none;font-weight:700;">{{ __('mail.email_support') }}</a>
                                        </div>
                                        <div style="margin-top:10px;color:#9ca3af; padding-bottom:10px;">Nha Trang –
                                            Khanh Hoa</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>