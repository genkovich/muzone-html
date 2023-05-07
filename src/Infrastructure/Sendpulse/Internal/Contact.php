<?php

declare(strict_types=1);

namespace Infrastructure\Sendpulse\Internal;

final readonly class Contact implements \JsonSerializable
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $phone,
        public array $messengers,
        public int $responsibleId,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phone' => $this->phone,
            'messengers' => $this->messengers,
            'responsibleId' => $this->responsibleId,
        ];
    }
}
