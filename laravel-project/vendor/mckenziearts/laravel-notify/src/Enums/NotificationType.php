<?php

declare(strict_types=1);

namespace Mckenziearts\Notify\Enums;

enum NotificationType: string
{
    case Success = 'success';

    case Error = 'error';

    case Warning = 'warning';

    case Info = 'info';

    public function getDefaultIcon(NotificationModel $model): ?string
    {
        return match ($this) {
            self::Success => match ($model) {
                NotificationModel::Toast => 'untitledui-check-circle',
                NotificationModel::Connect => 'untitledui-wifi',
                NotificationModel::Smiley => '👍',
                NotificationModel::Drake, NotificationModel::Emotify => null,
            },
            self::Error => match ($model) {
                NotificationModel::Toast => 'untitledui-x-circle',
                NotificationModel::Connect => 'untitledui-wifi-off',
                NotificationModel::Smiley => '🙅🏽‍♂',
                NotificationModel::Drake, NotificationModel::Emotify => null,
            },
            self::Warning => 'untitledui-alert-circle',
            self::Info => 'untitledui-info-circle',
        };
    }

    public function getDefaultTitle(): string
    {
        // @phpstan-ignore-next-line
        return match ($this) {
            self::Success => __('notify::notify.enums.success'),
            self::Error => __('notify::notify.enums.error'),
            self::Warning => __('notify::notify.enums.warning'),
            self::Info => __('notify::notify.enums.info'),
        };
    }
}
