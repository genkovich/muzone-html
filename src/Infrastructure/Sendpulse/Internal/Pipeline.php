<?php

declare(strict_types=1);

namespace Infrastructure\Sendpulse\Internal;

final readonly class Pipeline
{
    public function __construct(
        public int $id,
        public array $statuses,
        public array $directions,
        public array $teachers,
        public array $sources,
        public array $age,
    ) {
    }
}
