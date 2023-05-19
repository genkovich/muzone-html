<?php

declare(strict_types=1);

namespace Domain\Service;

use Domain\Age;
use Domain\Common\Currency;
use Domain\Direction;
use Domain\Service\Price\ServicePrice;
use Domain\Service\Price\ServicePriceFactory;
use Domain\Service\Price\ServicePriceId;

final readonly class ServiceFactory
{
    public function __construct(
        private ServicePriceFactory $servicePriceFactory,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function fromArray(array $data): Service
    {
        return new Service(
            new ServiceId($data['service_id']),
            new Title($data['title']),
            $this->servicePriceFactory->fromArray([
                'id' => $data['id'],
                'price' => $data['price'],
                'service_id' => $data['service_id'],
                'currency' => $data['currency'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ]),
            Direction::from($data['direction']),
            new LessonsCount($data['lessons_count']),
            Age::from($data['age']),
            new \DateTimeImmutable($data['created_at']),
            new \DateTimeImmutable($data['updated_at']),
        );
    }

    public function create(
        ServiceId $serviceId,
        string $title,
        ServicePriceId $servicePriceId,
        int $price,
        string $currency,
        string $direction,
        string $age,
        int $lessonsCount,
    ): Service
    {
        $now = new \DateTimeImmutable();
        return new Service(
            $serviceId,
            new Title($title),
            new ServicePrice(
                $servicePriceId,
                $serviceId,
                $price,
                Currency::from($currency),
                $now,
                $now,
            ),
            Direction::from($direction),
            new LessonsCount($lessonsCount),
            Age::from($age),
            $now,
            $now,
        );
    }
}
