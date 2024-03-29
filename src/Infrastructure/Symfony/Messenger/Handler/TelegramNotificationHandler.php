<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Messenger\Handler;

use Application\Lead\Notifier\NotifierInterface;
use Domain\Lead\Lead;
use Domain\Lead\LeadRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class TelegramNotificationHandler
{
    public function __construct(
        private NotifierInterface $notifier,
        private LeadRepositoryInterface $leadRepository,
    ) {
    }

    public function __invoke(Lead $lead): void
    {
        $this->notifier->notify($lead);
        $this->leadRepository->markTelegramSent($lead->id);
    }
}
