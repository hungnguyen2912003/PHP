<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <meta name="x-apple-disable-message-reformatting" />
        <title>{{ __('mail.contest_result.title') }}</title>
    </head>

    <body
        style="
            margin: 0;
            padding: 0;
            background: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            color: #111827;
        "
    >
        <!-- Preheader -->
        <div
            style="
                display: none;
                font-size: 1px;
                line-height: 1px;
                max-height: 0;
                max-width: 0;
                opacity: 0;
                overflow: hidden;
            "
        >
            {{ __('mail.contest_result.preheader') }}
        </div>

        <table
            role="presentation"
            width="100%"
            cellspacing="0"
            cellpadding="0"
            style="padding: 24px 0; border-collapse: collapse"
        >
            <tr>
                <td align="center" style="padding: 0 16px">
                    <table
                        role="presentation"
                        width="640"
                        cellspacing="0"
                        cellpadding="0"
                        style="max-width: 640px; width: 100%; border-collapse: collapse"
                    >
                        <!-- Card -->
                        <tr>
                            <td
                                style="
                                    background: #ffffff;
                                    border: 1px solid rgba(17, 24, 39, 0.08);
                                    box-shadow: 0 14px 40px rgba(17, 24, 39, 0.08);
                                    overflow: hidden;
                                "
                            >
                                <!-- Header -->
                                <table
                                    role="presentation"
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    style="border-collapse: collapse"
                                >
                                    <tr>
                                        <td
                                            style="
                                                padding: 22px 24px;
                                                background: linear-gradient(
                                                    135deg,
                                                    #065f46,
                                                    #047857
                                                );
                                            "
                                        >
                                            <div
                                                style="
                                                    font-size: 12px;
                                                    font-weight: 700;
                                                    color: #a7f3d0;
                                                    letter-spacing: 0.12em;
                                                    text-transform: uppercase;
                                                "
                                            >
                                                {{ __('mail.contest_result.header') }}
                                            </div>
                                            <div
                                                style="
                                                    margin-top: 8px;
                                                    font-size: 22px;
                                                    font-weight: 800;
                                                    color: #ffffff;
                                                "
                                            >
                                                {{ __('mail.contest_result.greeting', ['name' => $user->fullname]) }}
                                            </div>
                                            <div
                                                style="
                                                    margin-top: 8px;
                                                    font-size: 14px;
                                                    line-height: 1.7;
                                                    color: #d1fae5;
                                                "
                                            >
                                                {{ __('mail.contest_result.intro') }}
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Body -->
                                <table
                                    role="presentation"
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    style="border-collapse: collapse"
                                >
                                    <tr>
                                        <td style="padding: 24px; box-sizing: border-box">
                                            <!-- Rank Badge -->
                                            <table
                                                role="presentation"
                                                width="100%"
                                                cellpadding="0"
                                                cellspacing="0"
                                                style="
                                                    border-collapse: collapse;
                                                    margin-bottom: 20px;
                                                "
                                            >
                                                <tr>
                                                    <td align="center">
                                                        <div
                                                            style="
                                                                display: inline-block;
                                                                background: linear-gradient(
                                                                    135deg,
                                                                    #f59e0b,
                                                                    #d97706
                                                                );
                                                                border-radius: 50%;
                                                                width: 80px;
                                                                height: 80px;
                                                                line-height: 80px;
                                                                text-align: center;
                                                                font-size: 32px;
                                                                font-weight: 900;
                                                                color: #ffffff;
                                                            "
                                                        >
                                                            #{{ $rank }}
                                                        </div>
                                                        <div
                                                            style="
                                                                margin-top: 8px;
                                                                font-size: 18px;
                                                                font-weight: 800;
                                                                color: #d97706;
                                                            "
                                                        >
                                                            {{ __('mail.contest_result.rank_label', ['rank' => $rank]) }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Contest Info -->
                                            <table
                                                role="presentation"
                                                width="100%"
                                                cellpadding="0"
                                                cellspacing="0"
                                                style="
                                                    border-collapse: collapse;
                                                    background: #f9fafb;
                                                    border: 1px solid #e5e7eb;
                                                    border-radius: 14px;
                                                "
                                            >
                                                <tr>
                                                    <td
                                                        style="
                                                            padding: 16px;
                                                            box-sizing: border-box;
                                                        "
                                                    >
                                                        <div
                                                            style="
                                                                font-size: 13px;
                                                                line-height: 1.8;
                                                                color: #6b7280;
                                                            "
                                                        >
                                                            <div
                                                                style="
                                                                    font-weight: 700;
                                                                    color: #111827;
                                                                    margin-bottom: 6px;
                                                                    font-size: 15px;
                                                                "
                                                            >
                                                                {{ __('mail.contest_result.contest_details') }}
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.contest_name') }}:
                                                                </b>
                                                                {{ $contest->name }}
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.description') }}:
                                                                </b>
                                                                {{ $contest->description ?: __('value.not_available') }}
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.start_date') }}:
                                                                </b>
                                                                {{ $contest->start_date ? $contest->start_date->format('Y-m-d') : __('value.not_available') }}
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.end_date') }}:
                                                                </b>
                                                                {{ $contest->end_date ? $contest->end_date->format('Y-m-d') : __('value.not_available') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Your Result -->
                                            <table
                                                role="presentation"
                                                width="100%"
                                                cellpadding="0"
                                                cellspacing="0"
                                                style="
                                                    margin-top: 16px;
                                                    border-collapse: collapse;
                                                    background: #ecfdf5;
                                                    border: 1px solid #a7f3d0;
                                                    border-radius: 14px;
                                                "
                                            >
                                                <tr>
                                                    <td
                                                        style="
                                                            padding: 16px;
                                                            box-sizing: border-box;
                                                        "
                                                    >
                                                        <div
                                                            style="
                                                                font-size: 13px;
                                                                line-height: 1.8;
                                                                color: #065f46;
                                                            "
                                                        >
                                                            <div
                                                                style="
                                                                    font-weight: 700;
                                                                    color: #065f46;
                                                                    margin-bottom: 6px;
                                                                    font-size: 15px;
                                                                "
                                                            >
                                                                {{ __('mail.contest_result.your_result') }}
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.ranking_position') }}:
                                                                </b>
                                                                <span
                                                                    style="
                                                                        font-size: 16px;
                                                                        font-weight: 800;
                                                                        color: #d97706;
                                                                    "
                                                                >
                                                                    #{{ $rank }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.reward_points') }}:
                                                                </b>
                                                                <span
                                                                    style="
                                                                        font-size: 16px;
                                                                        font-weight: 800;
                                                                        color: #059669;
                                                                    "
                                                                >
                                                                    {{ number_format($reward) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.total_steps') }}:
                                                                </b>
                                                                {{ number_format($finalSteps) }}
                                                            </div>
                                                            <div>
                                                                <b>
                                                                    {{ __('mail.contest_result.joined_at') }}:
                                                                </b>
                                                                {{ $joinedAt ? $joinedAt->format('Y-m-d H:i:s') : __('value.not_available') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Congrats message -->
                                            <div
                                                style="
                                                    margin-top: 20px;
                                                    font-size: 14px;
                                                    line-height: 1.7;
                                                    color: #374151;
                                                    text-align: center;
                                                "
                                            >
                                                {{ __('mail.contest_result.congrats_message') }}
                                            </div>

                                            <!-- Divider -->
                                            <div
                                                style="
                                                    height: 1px;
                                                    background: #e5e7eb;
                                                    margin: 22px 0;
                                                "
                                            ></div>

                                            <!-- Tip -->
                                            <table
                                                role="presentation"
                                                width="100%"
                                                cellpadding="0"
                                                cellspacing="0"
                                                style="
                                                    border-collapse: collapse;
                                                    background: #eef2ff;
                                                    border: 1px solid #c7d2fe;
                                                    border-radius: 14px;
                                                "
                                            >
                                                <tr>
                                                    <td
                                                        style="
                                                            padding: 14px;
                                                            box-sizing: border-box;
                                                        "
                                                    >
                                                        <div
                                                            style="
                                                                font-size: 12px;
                                                                line-height: 1.7;
                                                                color: #3730a3;
                                                            "
                                                        >
                                                            <b>
                                                                {{ __('mail.contest_result.note_title') }}
                                                            </b>
                                                            {{ __('mail.contest_result.note_body') }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <!-- Footer -->
                                    <tr>
                                        <td
                                            align="center"
                                            style="
                                                padding: 18px 8px 0;
                                                font-size: 12px;
                                                line-height: 1.6;
                                                color: #6b7280;
                                            "
                                        >
                                            <div>
                                                {{ __('mail.contest_result.footer_reason') }}
                                            </div>
                                            <div style="margin-top: 6px">
                                                &copy; {{ now()->format('Y') }}
                                                {{ config('app.name') }} &bull;
                                                <a
                                                    href="/"
                                                    style="
                                                        color: #2563eb;
                                                        text-decoration: none;
                                                        font-weight: 700;
                                                    "
                                                >
                                                    {{ __('mail.email_website') }}
                                                </a>
                                                &bull;
                                                <a
                                                    href="/"
                                                    style="
                                                        color: #2563eb;
                                                        text-decoration: none;
                                                        font-weight: 700;
                                                    "
                                                >
                                                    {{ __('mail.email_support') }}
                                                </a>
                                            </div>
                                            <div
                                                style="
                                                    margin-top: 10px;
                                                    color: #9ca3af;
                                                    padding-bottom: 10px;
                                                "
                                            >
                                                Nha Trang &ndash; Khanh Hoa
                                            </div>
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
