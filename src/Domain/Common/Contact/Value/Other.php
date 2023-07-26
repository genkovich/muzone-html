<?php

declare(strict_types=1);

namespace Domain\Common\Contact\Value;

final readonly class Other implements ContactValueInterface
{
    public function __construct(public string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Contact value cannot be empty');
        }

        if (\mb_strlen($value) > 255) {
            throw new \InvalidArgumentException('Contact value cannot be longer than 255 characters');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
