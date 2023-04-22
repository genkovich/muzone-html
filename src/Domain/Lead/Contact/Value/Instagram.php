<?php
declare(strict_types=1);


namespace Domain\Lead\Contact\Value;

use InvalidArgumentException;

final readonly class Instagram implements ContactValueInterface
{
    public function __construct(public string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Instagram cannot be empty');
        }

        if (!preg_match('/^@?(\w){4,32}$/', $value)) {
            throw new InvalidArgumentException('Invalid instagram format');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}