<?php

declare(strict_types=1);

namespace Domain\Service;

use Domain\Age;
use Domain\Common\Currency;
use Domain\Direction;

final readonly class ServiceFactory
{
    /**
     * @throws \Exception
     */
    public function fromArray(array $data): Service
    {
        return new Service(
            new ServiceId($data['service_id']),
            new Title($data['title']),
            new Price($data['price'], Currency::from($data['currency'])),
            Direction::from($data['direction']),
            new LessonsCount($data['lessons_count']),
            Age::from($data['age']),
            new \DateTimeImmutable($data['created_at']),
            new \DateTimeImmutable($data['updated_at']),
        );
    }
}
