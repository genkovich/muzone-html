<?php
declare(strict_types=1);


namespace Domain\Lead;

use DateTimeImmutable;
use Domain\Lead\Contact\ContactFactory;
use Exception;

final readonly class LeadFactory
{
    public function __construct(
        private ContactFactory $contactFactory,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(array $data): Lead
    {
        return new Lead(
            new LeadId($data['lead_id']),
            $this->contactFactory->create($data['contact_type'], $data['contact_value']),
            new DateTimeImmutable($data['created_at']),
            new DateTimeImmutable($data['updated_at']),
        );
    }
}