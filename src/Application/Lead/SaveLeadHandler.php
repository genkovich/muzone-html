<?php
declare(strict_types=1);


namespace Application\Lead;

use Application\Lead\Notifier\NotifierInterface;
use Domain\Age;
use Domain\Direction;
use Domain\GroupType;
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
            lessonsCount: $command->lessonsCount,
            direction: Direction::tryFrom($command->direction),
            groupType: GroupType::tryFrom($command->groupType),
            age: Age::tryFrom($command->age),
            createdAt: $now,
            updatedAt: $now,
            telegramSentAt: Lead::DEFAULT_TELEGRAM_SENT_AT,
            sendpulseSentAt: Lead::DEFAULT_SENDPULSE_SENT_AT,
        );

        $this->leadRepository->insert($lead);

        $this->notifier->notify($lead);
    }

}