<?php

declare(strict_types=1);

namespace Infrastructure\Sendpulse\Internal;

enum Messenger: int
{
    case Telegram = 1;

    case Facebook = 2;

    case Vk = 3;

    case Instagram = 4;

    case Whatsapp = 5;

    case Viber = 6;
}
