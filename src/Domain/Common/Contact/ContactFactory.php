<?php

declare(strict_types=1);

namespace Domain\Common\Contact;

use Domain\Common\Contact\Value\Instagram;
use Domain\Common\Contact\Value\Other;
use Domain\Common\Contact\Value\Phone;
use Domain\Common\Contact\Value\Telegram;

final readonly class ContactFactory
{
    public function __construct()
    {
    }

    public function create(string $type, string $value): Contact
    {
        $contactType = ContactType::from($type);

        $contactValue = match ($contactType) {
            ContactType::Phone => Phone::fromString($value),
            ContactType::Telegram => new Telegram($value),
            ContactType::Instagram => new Instagram($value),
            default => new Other($value),
        };

        return new Contact($contactType, $contactValue);
    }
}
