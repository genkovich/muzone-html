<?php

declare(strict_types=1);

namespace Domain\Lead;

final readonly class LeadId
{
    public function __construct(public string $id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Lead id cannot be empty');
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
