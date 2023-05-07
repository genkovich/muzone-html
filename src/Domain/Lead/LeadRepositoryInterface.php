<?php

declare(strict_types=1);

namespace Domain\Lead;

interface LeadRepositoryInterface
{
    public function generateNext(): LeadId;

    public function insert(Lead $lead): void;

    public function getList(int $limit, int $offset): array;

    public function markTelegramSent(LeadId $leadId): void;

    public function markSendpulseSent(LeadId $leadId): void;
}
