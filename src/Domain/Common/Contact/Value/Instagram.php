<?php

declare(strict_types=1);

namespace Domain\Common\Contact\Value;

final readonly class Instagram implements ContactValueInterface
{
    public function __construct(public string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Instagram cannot be empty');
        }

        if (!\preg_match('/^[-:\/@#$\w_.]{4,150}$/', $value)) {
            throw new \InvalidArgumentException('Invalid format');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
