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
    )
    {
    }

    public function nextIdentity(): ServiceId
    {
        return new ServiceId((string)$this->uuidFactory->create());
    }

    /**
     * @throws Exception
     */
    public function add(Service $service): void
    {
        $this->connection->executeStatement(
            'INSERT INTO services (service_id, title, price, currency, direction, lessons_count, age, created_at, updated_at)
             VALUES (:service_id, :title, :price, :direction, :lessons_count, :age, :created_at, :updated_at)',
            [
                'service_id' => $service->serviceId,
                'title' => $service->title,
                'price' => $service->price->price,
                'currency' => $service->price->currency->value,
                'direction' => $service->direction,
                'lessons_count' => $service->lessonsCount,
                'age' => $service->age,
                'created_at' => $service->createdAt,
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
                'created_at' => Types::DATETIMETZ_IMMUTABLE,
                'updated_at' => Types::DATETIMETZ_IMMUTABLE,
            ],
        );
    }

    public function get(ServiceId $serviceId): Service
    {
        $result = $this->connection->executeQuery(
            'SELECT * FROM services WHERE service_id = :service_id',
            [
                'service_id' => $serviceId,
            ],
            [
                'service_id' => Types::GUID,
            ],
        );

        $data = $result->fetchAssociative();

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
            'DELETE FROM services WHERE service_id = :service_id',
            [
                'service_id' => $serviceId,
            ],
            [
                'service_id' => Types::GUID,
            ],
        );
    }

    public function list(int $limit, int $offset): array
    {
        $result = $this->connection->executeQuery(
            'SELECT * FROM services LIMIT :limit OFFSET :offset',
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

        return array_map(fn(array $item) => $this->serviceFactory->fromArray($item), $data);
    }


}