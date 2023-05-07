<?php

declare(strict_types=1);

namespace Infrastructure\Sendpulse;

use Domain\Lead\Lead;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Infrastructure\Sendpulse\Internal\Contact;
use Infrastructure\Sendpulse\Internal\Pipeline;
use Infrastructure\Sendpulse\Internal\Responsible;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

final class SendpulseClient
{
    private const SESSION_CACHE_PREFIX = 'sendpulse_token';

    private const EXPIRES_TIME_SECONDS = 3600;

    private const HASH_ALGO = 'sha256';

    private string $token;

    /**
     * @throws GuzzleException|InvalidArgumentException|\JsonException
     */
    public function __construct(
        private readonly Client $client,
        private readonly string $clientSecret,
        private readonly string $clientId,
        private readonly CacheInterface $cache,
    ) {
        $this->token = '';

        $credentialString = \sprintf(
            '%s-%s',
            $this->clientSecret,
            $this->clientId
        );

        $sessionKey = \sprintf('%s-%s', self::SESSION_CACHE_PREFIX, \hash(self::HASH_ALGO, $credentialString));

        $accessToken = $this->cache->get($sessionKey);

        if (null === $accessToken) {
            $accessToken = $this->getToken();
            $this->cache->set($sessionKey, $accessToken, self::EXPIRES_TIME_SECONDS);
        }

        $this->token = $accessToken;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getMessengerTypes(): array
    {
        return $this->sendRequest('GET', '/crm/v1/messenger-types');
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function listDeals(int $pipelineId): array
    {
        return $this->sendRequest('POST', '/crm/v1/deals/get-list', [
            'limit' => 20,
            'offset' => 0,
            'pipelineIds' => [$pipelineId],
        ]);
    }

    public function createDeal(Lead $lead, int $contactId, Pipeline $pipeline): array
    {
        $deal = [
            'pipelineId' => $pipeline->id,
            'stepId' => $pipeline->statuses['contacted'],
            'responsibleId' => Responsible::Muzone->value,
            'name' => 'Site: '.$lead->contact->type->value.' '.$lead->contact->value,
            'contact' => [
                'id' => $contactId,
            ],
            'attributes' => [
                [
                    'attributeId' => $pipeline->sources['id'],
                    'value' => $pipeline->sources['options']['site'],
                ],
            ],
        ];

        if (null !== $lead->direction) {
            $deal['attributes'][] = [
                'attributeId' => $pipeline->directions['id'],
                'value' => $pipeline->directions['options'][$lead->direction->value] ?? 'Інше',
            ];
        }

        if (null !== $lead->age) {
            $deal['attributes'][] = [
                'attributeId' => $pipeline->age['id'],
                'value' => $pipeline->age['options'][$lead->age->value] ?? '',
            ];
        }

        return $this->sendRequest('POST', '/crm/v1/deals', $deal);
    }

    public function getDealAttributes(int $dealId): array
    {
        return $this->sendRequest('GET', '/crm/v1/deals/'.$dealId.'/attributes');
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function createContact(Contact $contact): array
    {
        return $this->sendRequest('POST', '/crm/v1/contacts', $contact->jsonSerialize());
    }

    /**
     * @throws GuzzleException|\JsonException
     */
    private function getToken(): string
    {
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];

        $response = $this->sendRequest('POST', '/oauth/access_token', $data);

        if (!isset($response['access_token'])) {
            throw new \RuntimeException('SendPulse authentication failed: '.\json_encode($response, JSON_THROW_ON_ERROR));
        }

        return $response['access_token'];
    }

    /**
     * @param mixed $data
     *
     * @throws GuzzleException
     * @throws \JsonException
     */
    private function sendRequest(string $method, string $url, $data = []): array
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        if ('' !== $this->token) {
            $headers['Authorization'] = 'Bearer '.$this->token;
        }

        $request = new Request($method, $url, $headers, \json_encode($data, JSON_THROW_ON_ERROR));

        $response = $this->client->send($request);

        $body = $response->getBody()->getContents();

        return \json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }
}
