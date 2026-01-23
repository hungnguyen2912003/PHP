<?php

declare(strict_types=1);

namespace Mckenziearts\Notify\Enums;

enum NotificationModel: string
{
    case Toast = 'toast';

    case Connect = 'connect';

    case Smiley = 'smiley';

    case Emotify = 'emotify';

    case Drake = 'drake';

    public function getViewName(): string
    {
        return match ($this) {
            self::Toast => 'notify::notifications.toast',
            self::Connect => 'notify::notifications.connectify',
            self::Smiley => 'notify::notifications.smiley',
            self::Emotify => 'notify::notifications.emotify',
            self::Drake => 'notify::notifications.drakify',
        };
    }
}
