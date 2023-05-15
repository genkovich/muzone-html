<?php
declare(strict_types=1);


namespace Domain\Service\Price;

final readonly class ServicePriceId
{
    public function __construct(
        public string $value,
    ) {
        if (empty($this->value)) {
            throw new \InvalidArgumentException('PriceId cannot be empty');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

}