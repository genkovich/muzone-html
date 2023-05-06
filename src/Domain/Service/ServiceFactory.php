<?php
declare(strict_types=1);


namespace Domain\Service;

use Domain\Age;
use Domain\Common\Currency;
use Domain\Direction;

final readonly class ServiceFactory
{
    public function fromArray(array $data): Service
    {
        return new Service(
            new ServiceId($data['service_id']),
            new Title($data['title']),
            new Price($data['price'], Currency::tryFrom($data['currency'])),
            Direction::tryFrom($data['direction']),
            new LessonsCount($data['lessons_count']),
            Age::tryFrom($data['age']),
            new \DateTimeImmutable($data['created_at']),
            new \DateTimeImmutable($data['updated_at']),
        );
    }

}