<?php

declare(strict_types=1);

namespace Domain\Service;

use Domain\Age;
use Domain\Direction;
use Domain\Service\Price\ServicePrice;

final readonly class Service
{
    public function __construct(
        public ServiceId $serviceId,
        public Title $title,
        public ServicePrice $price,
        public Direction $direction,
        public LessonsCount $lessonsCount,
        public Age $age,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }
}
