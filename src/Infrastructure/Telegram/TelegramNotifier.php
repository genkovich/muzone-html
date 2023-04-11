<?php
declare(strict_types=1);


namespace Infrastructure\Telegram;

use Application\Lead\Notifier\NotifierInterface;
use Domain\Lead\Lead;
use GuzzleHttp\Exception\GuzzleException;

final readonly class TelegramNotifier implements NotifierInterface
{

    public function __construct(
        private string $chatId,
        private TelegramClient $client,
    )
    {
    }

    /**
     * @throws GuzzleException
     */
    public function notify(Lead $lead): void
    {
        $message = sprintf(
            'New lead from %s %s',
            $lead->contact->type->value,
            $lead->contact->value
        );

        $this->client->notify($this->chatId, $message);
    }
}