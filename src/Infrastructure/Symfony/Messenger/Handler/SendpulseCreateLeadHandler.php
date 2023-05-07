<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Messenger\Handler;

use Domain\GroupType;
use Domain\Lead\Lead;
use Domain\Lead\LeadRepositoryInterface;
use GuzzleHttp\Exception\GuzzleException;
use Infrastructure\InMemory\InMemoryPipelineRepository;
use Infrastructure\Sendpulse\Convertors\LeadToContactConvertor;
use Infrastructure\Sendpulse\Internal\PipelineId;
use Infrastructure\Sendpulse\SendpulseClient;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SendpulseCreateLeadHandler
{
    public function __construct(
        private LeadToContactConvertor $converter,
        private SendpulseClient $sendpulseClient,
        private InMemoryPipelineRepository $pipelineRepository,
        private LeadRepositoryInterface $leadRepository,
    ) {
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function __invoke(Lead $lead): void
    {
        $convertedContact = $this->converter->convert($lead);

        $response = $this->sendpulseClient->createContact($convertedContact);

        $pipelineId = match ($lead->groupType) {
            GroupType::Group => PipelineId::Group->value,
            default => PipelineId::Individual->value,
        };

        $pipeline = $this->pipelineRepository->findById($pipelineId);

        if (null === $pipeline) {
            throw new \RuntimeException('Pipeline not found');
        }

        $this->sendpulseClient->createDeal($lead, $response['data']['id'], $pipeline);

        $this->leadRepository->markSendpulseSent($lead->id);
    }
}
