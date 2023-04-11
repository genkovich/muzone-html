<?php
declare(strict_types=1);


namespace Domain\Lead;

use Domain\Lead\Contact\Contact;

final readonly class Lead implements \JsonSerializable
{
    public function __construct(
        public LeadId $id,
        public Contact $contact,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'contact' => $this->contact,
            'createdAt' => $this->createdAt->format(\DateTimeInterface::RFC3339_EXTENDED),
            'updatedAt' => $this->updatedAt->format(\DateTimeInterface::RFC3339_EXTENDED),
        ];
    }
}