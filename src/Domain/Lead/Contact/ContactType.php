<?php

declare(strict_types=1);

namespace Domain\Lead\Contact;

enum ContactType: string
{
    case Phone = 'phone';

    case Telegram = 'telegram';

    case Instagram = 'instagram';

    case Other = 'other';
}
