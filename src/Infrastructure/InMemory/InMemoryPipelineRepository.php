<?php
declare(strict_types=1);


namespace Infrastructure\InMemory;

use Infrastructure\Sendpulse\Internal\Pipeline;

final class InMemoryPipelineRepository
{
    private array $pipelines;

    public function __construct(array $config)
    {
        foreach ($config as $pipelineConfig) {
            $pipeline = new Pipeline(
                $pipelineConfig['id'],
                $pipelineConfig['statuses'],
                $pipelineConfig['directions'],
                $pipelineConfig['teachers'],
                $pipelineConfig['sources'],
                $pipelineConfig['age']
            );

            $this->pipelines[$pipeline->id] = $pipeline;
        }
    }

    public function findById(int $id): ?Pipeline
    {
        return $this->pipelines[$id] ?? null;
    }

}