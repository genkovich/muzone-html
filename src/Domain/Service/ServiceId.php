<?php

declare(strict_types=1);

namespace Domain\Service;

final readonly class ServiceId
{
    public function __construct(
        public string $value,
    ) {
        if (empty($value)) {
            throw new \InvalidArgumentException('Service id cannot be empty');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
