<?php

declare(strict_types=1);

namespace Domain\User;

final readonly class UserId implements \Stringable
{
    public function __construct(
        private string $id,
    ) {
        if ('' === $this->id) {
            throw new \InvalidArgumentException('Invalid User identifier');
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
