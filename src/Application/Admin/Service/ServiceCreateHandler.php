<?php
declare(strict_types=1);


namespace Application\Admin\Service;

use Domain\Service\ServiceFactory;
use Infrastructure\Persistence\Psql\Repository\ServiceRepository;

final readonly class ServiceCreateHandler
{
    public function __construct(
        private ServiceRepository $serviceRepository,
        private ServiceFactory $serviceFactory,
    )
    {
    }

    public function handle(ServiceCreateCommand $serviceCreateCommand): void
    {
        $serviceId = $this->serviceRepository->nextIdentity();
        $servicePriceId = $this->serviceRepository->nextServicePriceIdentity();

        $service = $this->serviceFactory->create(
            $serviceId,
            $serviceCreateCommand->title,
            $servicePriceId,
            $serviceCreateCommand->price,
            $serviceCreateCommand->currency,
            $serviceCreateCommand->direction,
            $serviceCreateCommand->age,
            $serviceCreateCommand->lessonsCount,
        );

        $this->serviceRepository->add($service);

    }
}