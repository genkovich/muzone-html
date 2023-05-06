<?php
declare(strict_types=1);


namespace Domain\Service;

use Domain\Common\Currency;

final readonly class Price
{
    public function __construct(
        public int|string $price,
        public Currency $currency,
    )
    {
        if ($this->price < 0) {
            throw new \InvalidArgumentException('Price cannot be less than 0');
        }
    }

    public function __toString(): string
    {
        return (string)$this->price;
    }

}