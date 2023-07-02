<?php

declare(strict_types=1);

namespace Infrastructure\Sendpulse\Internal;

final readonly class Contact implements \JsonSerializable
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public int $phone,
        public array $messengers,
        public int $responsibleId,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phones' => [$this->phone], //todo: add other phones
            'messengers' => $this->messengers,
            'responsibleId' => $this->responsibleId,
        ];
    }
}
