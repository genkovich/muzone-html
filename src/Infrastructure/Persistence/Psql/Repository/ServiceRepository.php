<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Psql\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Types;
use Domain\Service\Service;
use Domain\Service\ServiceFactory;
use Domain\Service\ServiceId;
use Domain\Service\ServiceRepositoryInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class ServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private UuidFactory $uuidFactory,
        private ServiceFactory $serviceFactory,
    ) {
    }

    public function nextIdentity(): ServiceId
    {
        return new ServiceId((string) $this->uuidFactory->create());
    }

    /**
     * @throws Exception
     */
    public function add(Service $service): void
    {
        try {
            $this->connection->beginTransaction();
            $this->connection->executeStatement(
                'INSERT INTO services (service_id, title, direction, lessons_count, age, created_at, updated_at)
             VALUES (:service_id, :title, :direction, :lessons_count, :age, :created_at, :updated_at)',
                [
                    'service_id' => $service->serviceId,
                    'title' => $service->title,
                    'direction' => $service->direction->value,
                    'lessons_count' => $service->lessonsCount,
                    'age' => $service->age->value,
                    'created_at' => $service->createdAt,
                    'updated_at' => $service->updatedAt,
                ],
                [
                    'service_id' => Types::GUID,
                    'title' => Types::STRING,
                    'direction' => Types::STRING,
                    'lessons_count' => Types::INTEGER,
                    'age' => Types::STRING,
                    'created_at' => Types::DATETIMETZ_IMMUTABLE,
                    'updated_at' => Types::DATETIMETZ_IMMUTABLE,
                ],
            );

            $this->connection->executeStatement(
                'INSERT INTO service_prices (id, service_id, price, currency, start_date, created_at, updated_at)
             VALUES (:id, :service_id, :price, :currency, :start_date, :created_at, :updated_at)',
                [
                    'id' => $this->uuidFactory->create(),
                    'service_id' => $service->serviceId,
                    'price' => $service->price->price,
                    'currency' => $service->price->currency->value,
                    'start_date' => $service->createdAt,
                    'created_at' => $service->createdAt,
                    'updated_at' => $service->updatedAt,

                ],
                [
                    'id' => Types::GUID,
                    'service_id' => Types::GUID,
                    'price' => Types::INTEGER,
                    'currency' => Types::STRING,
                    'start_date' => Types::DATETIMETZ_IMMUTABLE,
                    'created_at' => Types::DATETIMETZ_IMMUTABLE,
                    'updated_at' => Types::DATETIMETZ_IMMUTABLE,
                ],
            );

            $this->connection->commit();
        } catch (Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }
    }

    public function find(ServiceId $serviceId): ?Service
    {
        $result = $this->connection->executeQuery(
        'SELECT s.*, sp.*
             FROM services s
             JOIN service_prices sp ON s.service_id = sp.service_id
             WHERE s.service_id = :service_id AND s.deleted_at IS NULL
             ORDER BY sp.start_date DESC
             LIMIT 1',
            [
                'service_id' => $serviceId,
            ],
            [
                'service_id' => Types::GUID,
            ],
        );

        $data = $result->fetchAssociative();

        if (false === $data) {
            return null;
        }

        return $this->serviceFactory->fromArray($data);
    }

    public function update(Service $service): void
    {
        $this->connection->executeStatement(
            'UPDATE services SET title = :title, price = :price, currency = :currency, direction = :direction, lessons_count = :lessons_count, age = :age, updated_at = :updated_at WHERE service_id = :service_id',
            [
                'service_id' => $service->serviceId,
                'title' => $service->title,
                'price' => $service->price->price,
                'currency' => $service->price->currency->value,
                'direction' => $service->direction,
                'lessons_count' => $service->lessonsCount,
                'age' => $service->age,
                'updated_at' => $service->updatedAt,
            ],
            [
                'service_id' => Types::GUID,
                'title' => Types::STRING,
                'price' => Types::STRING,
                'currency' => Types::STRING,
                'direction' => Types::STRING,
                'lessons_count' => Types::INTEGER,
                'age' => Types::STRING,
                'updated_at' => Types::DATETIMETZ_IMMUTABLE,
            ],
        );
    }

    public function remove(ServiceId $serviceId): void
    {
        $this->connection->executeStatement(
            'UPDATE services SET deleted_at = :deleted_at WHERE service_id = :service_id',
            [
                'service_id' => $serviceId,
                'deleted_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s.u'),
            ],
            [
                'service_id' => Types::GUID,
                'deleted_at' => Types::DATETIMETZ_IMMUTABLE,
            ],
        );
    }

    public function list(int $limit, int $offset): array
    {
        $result = $this->connection->executeQuery(
        'SELECT s.*, sp.*
             FROM services s
             JOIN service_prices sp ON s.service_id = sp.service_id
             AND sp.start_date = (
                 SELECT MAX(start_date)
                 FROM service_prices
                 WHERE service_id = s.service_id
             )
             WHERE s.deleted_at IS NULL
             ORDER BY s.service_id
             LIMIT :limit OFFSET :offset',
            [
                'limit' => $limit,
                'offset' => $offset,
            ],
            [
                'limit' => Types::INTEGER,
                'offset' => Types::INTEGER,
            ],
        );

        $data = $result->fetchAllAssociative();

        return \array_map(fn (array $item) => $this->serviceFactory->fromArray($item), $data);
    }

    public function getServicePrices(ServiceId $serviceId): array
    {
        $result = $this->connection->executeQuery(
            'SELECT *
             FROM service_prices
             WHERE service_id = :service_id
             ORDER BY start_date DESC',
            [
                'service_id' => $serviceId,
            ],
            [
                'service_id' => Types::GUID,
            ],
        );

        $data = $result->fetchAllAssociative();

        return \array_map(fn (array $item) => $this->servicePriceFactory->fromArray($item), $data);
    }
}
