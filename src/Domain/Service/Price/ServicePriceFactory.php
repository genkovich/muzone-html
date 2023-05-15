<?php
declare(strict_types=1);


namespace Domain\Service\Price;

use Domain\Common\Currency;
use Domain\Service\ServiceId;

final readonly class ServicePriceFactory
{
    public function create(
        ServicePriceId $servicePriceId,
        ServiceId $serviceId,
        int|string $price,
        Currency $currency,
        ?\DateTimeImmutable $startDate = null,
        ?\DateTimeImmutable $endDate = null,
    ): ServicePrice {
        return new ServicePrice(
            $servicePriceId,
            $serviceId,
            $price,
            $currency,
            $startDate,
            $endDate,
        );
    }

    public function fromArray(array $data): ServicePrice
    {
        $endDate = $data['end_date'] ? new \DateTimeImmutable($data['end_date']) : null;

        return new ServicePrice(
            new ServicePriceId($data['id']),
            new ServiceId($data['service_id']),
            $data['price'],
            Currency::from($data['currency']),
            new \DateTimeImmutable($data['start_date']),
            $endDate,
        );
    }

}