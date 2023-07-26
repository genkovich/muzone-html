<?php

declare(strict_types=1);

namespace Domain\Common\Contact;

enum ContactType: string
{
    case Phone = 'phone';

    case Telegram = 'telegram';

    case Instagram = 'instagram';

    case Other = 'other';
}
