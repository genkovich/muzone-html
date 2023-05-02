<?php
declare(strict_types=1);


namespace Application\Lead;

final readonly class SaveLeadCommand
{
    public function __construct(
        public string $contactValue,
        public string $contactType,
        public int $lessonsCount = 0,
        public string $direction = '',
        public string $groupType = '',
        public string $age = '',
    ) {}

}