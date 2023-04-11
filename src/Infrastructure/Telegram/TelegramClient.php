<?php
declare(strict_types=1);


namespace Infrastructure\Telegram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final readonly class TelegramClient
{

    private string $baseUrl;
    public function __construct(
        private string $botToken,
        private Client $client,
    )
    {
        $this->baseUrl = 'https://api.telegram.org';
    }

    /**
     * @throws GuzzleException
     */
    public function notify(string $chatId, string $message): void
    {
        $this->client->post($this->generateEndpoint('sendMessage'), [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ]
        ]);
    }

    private function generateEndpoint(string $method): string
    {
        return sprintf('%s/bot%s/%s', $this->baseUrl, $this->botToken, $method);
    }
}