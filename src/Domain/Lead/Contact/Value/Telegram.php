<?php
declare(strict_types=1);


namespace Domain\Lead\Contact\Value;

final readonly class Telegram implements ContactValueInterface
{

    public function __construct(public string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Telegram cannot be empty');
        }

        if (!preg_match('/^[\w_@.\/:-]{4,32}$/', $value)) {
            throw new \InvalidArgumentException('Telegram is not valid');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}