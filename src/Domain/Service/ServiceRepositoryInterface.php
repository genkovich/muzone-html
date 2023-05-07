<?php

declare(strict_types=1);

namespace Domain\Service;

interface ServiceRepositoryInterface
{
    public function nextIdentity(): ServiceId;

    public function add(Service $service): void;

    public function find(ServiceId $serviceId): ?Service;

    public function update(Service $service): void;

    public function remove(ServiceId $serviceId): void;

    public function list(int $limit, int $offset): array;
}
