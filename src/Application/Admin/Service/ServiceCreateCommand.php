<?php
declare(strict_types=1);


namespace Application\Admin\Service;

final readonly class ServiceCreateCommand
{
    public function __construct(
        public string $title,
        public int $price,
        public string $currency,
        public string $direction,
        public string $age,
        public int $lessonsCount,
    )
    {
    }

}