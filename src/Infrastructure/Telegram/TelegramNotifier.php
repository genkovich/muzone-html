<?php

declare(strict_types=1);

namespace Infrastructure\Telegram;

use Application\Lead\Notifier\NotifierInterface;
use Domain\Lead\Lead;
use GuzzleHttp\Exception\GuzzleException;
use Twig\Environment;

final readonly class TelegramNotifier implements NotifierInterface
{
    public function __construct(
        private string $chatId,
        private string $threadId,
        private TelegramClient $client,
        private Environment $twig,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function notify(Lead $lead): void
    {
        $html = $this->twig->render('telegram/notifier/lead_created_notification.html.twig', ['lead' => $lead]);

        $this->client->sendMessage($html, $this->chatId, $this->threadId);
    }
}
