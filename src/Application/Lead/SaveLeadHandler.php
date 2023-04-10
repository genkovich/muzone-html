<?php
declare(strict_types=1);


namespace Application\Lead;

use Domain\Lead\Contact\ContactFactory;
use Domain\Lead\Lead;
use Domain\Lead\LeadRepositoryInterface;

final readonly class SaveLeadHandler
{
    public function __construct(
        private LeadRepositoryInterface $leadRepository,
        private ContactFactory $contactFactory,
    ) {}

    public function handle(SaveLeadCommand $command): void
    {
        $contact = $this->contactFactory->create(
            $command->contactType,
            $command->contactValue,
        );

        $now = new \DateTimeImmutable();

        $lead = new Lead(
            id: $this->leadRepository->generateNext(),
            contact: $contact,
            createdAt: $now,
            updatedAt: $now,
        );

        $this->leadRepository->insert($lead);
    }

}