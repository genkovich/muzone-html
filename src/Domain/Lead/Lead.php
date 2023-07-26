<?php

declare(strict_types=1);

namespace Domain\Lead;

use Domain\Age;
use Domain\Common\Contact\Contact;
use Domain\Direction;
use Domain\GroupType;

final readonly class Lead implements \JsonSerializable
{
    public const DEFAULT_TELEGRAM_SENT_AT = null;
    public const DEFAULT_SENDPULSE_SENT_AT = null;

    public function __construct(
        public LeadId $id,
        public Contact $contact,
        public int $lessonsCount,
        public ?Direction $direction,
        public ?GroupType $groupType,
        public ?Age $age,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
        public ?\DateTimeImmutable $telegramSentAt,
        public ?\DateTimeImmutable $sendpulseSentAt,
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
            'telegramSentAt' => $this->telegramSentAt?->format(\DateTimeInterface::RFC3339_EXTENDED),
            'sendpulseSentAt' => $this->sendpulseSentAt?->format(\DateTimeInterface::RFC3339_EXTENDED),
        ];
    }
}
