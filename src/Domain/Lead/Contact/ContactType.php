<?php

namespace Domain\Lead\Contact;

enum ContactType: string
{
    case Phone = 'phone';

    case Telegram = 'telegram';

    case Instagram = 'instagram';

    case Other = 'other';
}
