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
            'INSERT INTO service_prices (id, service_id, currency, price, start_date, end_date, created_at, updated_at)
                VALUES (:id, :service_id, :currency, :price, :start_date, :end_date, :created_at, :updated_at)',
            [
                'id' => $this->uuidFactory->create(),
                'service_id' => $service->serviceId,
                'currency' => $service->price->currency->value,
                'price' => $service->price->price,
                'start_date' => $service->createdAt,
                'end_date' => null,
                'created_at' => $service->createdAt,
                'updated_at' => $service->updatedAt,
            ],
            [
                'id' => Types::GUID,
                'service_id' => Types::GUID,
                'currency' => Types::STRING,
                'price' => Types::STRING,
                'start_date' => Types::DATETIMETZ_IMMUTABLE,
                'end_date' => Types::DATETIMETZ_IMMUTABLE,
                'created_at' => Types::DATETIMETZ_IMMUTABLE,
                'updated_at' => Types::DATETIMETZ_IMMUTABLE,
            ]

        );
    }

    public function find(ServiceId $serviceId): ?Service
    {
        $result = $this->connection->executeQuery(
            'SELECT * FROM services 
                LEFT JOIN service_prices sp on services.service_id = sp.service_id
                WHERE  services.service_id = :service_id',
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

    public function servicePrices(ServiceId $serviceId): array
    {
        $result = $this->connection->executeQuery(
            'SELECT * FROM service_prices WHERE service_id = :service_id',
            [
                'service_id' => $serviceId,
            ],
            [
                'service_id' => Types::GUID,
            ],
        );

        return $result->fetchAllAssociative();

    }

    public function update(Service $service): void
    {
        $this->connection->executeStatement(
            'UPDATE services SET title = :title, direction = :direction, lessons_count = :lessons_count, age = :age, updated_at = :updated_at WHERE service_id = :service_id',
            [
                'service_id' => $service->serviceId,
                'title' => $service->title,
                'direction' => $service->direction,
                'lessons_count' => $service->lessonsCount,
                'age' => $service->age,
                'updated_at' => $service->updatedAt,
            ],
            [
                'service_id' => Types::GUID,
                'title' => Types::STRING,
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
            'DELETE FROM services WHERE service_id = :service_id',
            [
                'service_id' => $serviceId,
            ],
            [
                'service_id' => Types::GUID,
            ],
        );
    }

    public function list(int $limit, int $offset, array $filter = []): array
    {

        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')
            ->from('services')
            ->leftJoin('services', 'service_prices', 'service_prices', 'services.service_id = service_prices.service_id')
            ->where('service_prices.end_date IS NULL')
            ->orderBy('services.direction ASC, services.age')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        if (isset($filter['direction'])) {
            $qb->andWhere('services.direction = :direction')
                ->setParameter('direction', $filter['direction']);
        }

        if (isset($filter['age'])) {
            $qb->andWhere('services.age = :age')
                ->setParameter('age', $filter['age']);
        }

        $result = $qb->executeQuery();

        $data = $result->fetchAllAssociative();

        return \array_map(fn (array $item) => $this->serviceFactory->fromArray($item), $data);
    }
}
