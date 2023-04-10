<?php
declare(strict_types=1);


namespace Domain\Lead\Contact;

use Domain\Lead\Contact\Value\ContactValueInterface;

final readonly class Contact implements \JsonSerializable
{
    public function __construct(public ContactType $type, public ContactValueInterface $value)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'contact_type' => $this->type,
            'contact_value' => $this->value,
        ];
    }
}