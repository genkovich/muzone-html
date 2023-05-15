<?php

declare(strict_types=1);

namespace Domain\Service\Price;

use Domain\Common\Currency;
use Domain\Service\ServiceId;

final readonly class ServicePrice
{
    public function __construct(
        public ServicePriceId $id,
        public ServiceId $serviceId,
        public int|string $price,
        public Currency $currency,
        public ?\DateTimeImmutable $startDate = null,
        public ?\DateTimeImmutable $endDate = null,
    ) {
        if ($this->price < 0) {
            throw new \InvalidArgumentException('Price cannot be less than 0');
        }
    }

    public function __toString(): string
    {
        return (string) $this->price;
    }
}
