<?php

declare(strict_types=1);

namespace Infrastructure\Sendpulse\Convertors;

use Domain\Lead\Contact\ContactType;
use Domain\Lead\Lead;
use Infrastructure\Sendpulse\Internal\Contact;
use Infrastructure\Sendpulse\Internal\Messenger;
use Infrastructure\Sendpulse\Internal\Responsible;

final readonly class LeadToContactConvertor
{
    public function convert(Lead $lead): Contact
    {
        $contactValue = match ($lead->contact->type) {
            ContactType::Instagram => $this->extractInstagramUsername((string) $lead->contact->value),
            ContactType::Telegram => $this->extractTelegramUsername((string) $lead->contact->value),
            default => (string) $lead->contact->value,
        };

        $phone = ContactType::Phone === $lead->contact->type ? (string) $lead->contact->value : '';

        $messengers = [];

        $messengerId = match ($lead->contact->type) {
            ContactType::Instagram => Messenger::Instagram,
            ContactType::Telegram => Messenger::Telegram,
            default => null,
        };

        if (null !== $messengerId) {
            $messengers[] = [
                'typeId' => $messengerId->value,
                'login' => $contactValue,
            ];
        }

        return new Contact(
            firstName: $contactValue ?? '',
            lastName: '',
            phone: $phone,
            messengers: $messengers,
            responsibleId: Responsible::Muzone->value,
        );
    }

    public function extractInstagramUsername(string $input): ?string
    {
        $input = \trim($input);

        $urlPattern = '/^https?:\/\/(www\.)?instagram\.com\//';
        $input = \preg_replace($urlPattern, '', $input);

        return \str_replace('@', '', $input);
    }

    public function extractTelegramUsername(string $input): ?string
    {
        $input = \trim($input);

        $urlPattern = '/^https?:\/\/(t\.me|telegram\.me)\//';
        $input = \preg_replace($urlPattern, '', $input);

        return \ltrim($input, '@');
    }
}
