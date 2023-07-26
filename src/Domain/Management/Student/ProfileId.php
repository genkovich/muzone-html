<?php

declare(strict_types=1);

namespace Domain\Management\Student;

final readonly class ProfileId
{
    public function __construct(
        public string $id,
    )
    {
        if ('' === $this->id) {
            throw new \InvalidArgumentException('Invalid ClientProfile identifier');
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}