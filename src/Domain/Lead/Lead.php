<?php
declare(strict_types=1);


namespace Domain\Lead;

use Domain\Age;
use Domain\Direction;
use Domain\GroupType;
use Domain\Lead\Contact\Contact;

final readonly class Lead implements \JsonSerializable
{
    public function __construct(
        public LeadId $id,
        public Contact $contact,
        public int $lessonsCount,
        public ?Direction $direction,
        public ?GroupType $groupType,
        public ?Age $age,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'contact' => $this->contact,
            'lessonsCount' => $this->lessonsCount,
            'direction' => $this->direction ?? Direction::Unknown,
            'groupType' => $this->groupType ?? GroupType::Unknown,
            'age' => $this->age ?? Age::Unknown,
            'createdAt' => $this->createdAt->format(\DateTimeInterface::RFC3339_EXTENDED),
            'updatedAt' => $this->updatedAt->format(\DateTimeInterface::RFC3339_EXTENDED),
        ];
    }
}