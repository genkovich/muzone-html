<?php

declare(strict_types=1);

namespace Domain\Lead\Contact\Value;

final readonly class Phone implements ContactValueInterface
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new \InvalidArgumentException('Phone cannot be empty');
        }

        if (!\preg_match('/^[+]?\d{6,14}$/', $this->value)) {
            throw new \InvalidArgumentException('Phone is not valid');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): self
    {
        $phone = \preg_replace('/[^\d+]/', '', $value);

        return new self($phone);
    }
}
