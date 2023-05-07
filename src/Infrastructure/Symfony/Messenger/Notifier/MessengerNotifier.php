<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Messenger\Notifier;

use Application\Lead\Notifier\NotifierInterface;
use Domain\Lead\Lead;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerNotifier implements NotifierInterface
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {
    }

    public function notify(Lead $lead): void
    {
        $this->bus->dispatch($lead);
    }
}
