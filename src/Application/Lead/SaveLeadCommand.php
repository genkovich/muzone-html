<?php
declare(strict_types=1);


namespace Application\Lead;

final readonly class SaveLeadCommand
{
    public function __construct(
        public string $contactValue,
        public string $contactType,
    ) {}

}