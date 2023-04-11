<?php
declare(strict_types=1);


namespace Application\Lead;

use Application\Lead\Notifier\NotifierInterface;
use Domain\Lead\Contact\ContactFactory;
use Domain\Lead\Lead;
use Domain\Lead\LeadRepositoryInterface;

final readonly class SaveLeadHandler
{
    public function __construct(
        private LeadRepositoryInterface $leadRepository,
        private ContactFactory $contactFactory,
        private NotifierInterface $notifier,
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

        $this->notifier->notify($lead);
    }

}