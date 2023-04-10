<?php
declare(strict_types=1);


namespace Domain\Lead;

interface LeadRepositoryInterface
{
    public function generateNext(): LeadId;
    public function insert(Lead $lead): void;
}