<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Psql\User;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Types;
use Domain\User\User;
use Domain\User\UserId;
use Domain\User\UserRepositoryInterface;
use JsonException;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private UuidFactory $uuidGenerator,
        private Connection $connection,
        private UserFactory $userFactory,
    ) {
    }

    public function nextIdentity(): UserId
    {
        $uuid = $this->uuidGenerator->create();

        return new UserId((string)$uuid);
    }

    /**
     * @throws Exception|JsonException
     */
    public function findById(UserId $userId): ?User
    {
        $result = $this->connection->executeQuery(
            'SELECT user_id, roles, email, avatar_url, name, surname
             FROM auth_user
             WHERE user_id = :user_id',
            ['user_id' => (string)$userId],
        );

        $data = $result->fetchAssociative();

        if (false === $data) {
            return null;
        }

        return $this->userFactory->createFromData($data);
    }

    /**
     * @throws Exception|JsonException
     */
    public function getList(
        int $limit = 10,
        int $offset = 0,
    ): array {
        $result = $this->connection->executeQuery(
            'SELECT user_id, roles, email, avatar_url, name, surname
             FROM auth_user
             LIMIT :limit
             OFFSET :offset',
            [
                'limit' => $limit,
                'offset' => $offset,
            ],
        );

        $data = $result->fetchAllAssociative();

        if ([] === $data) {
            return [];
        }

        $users = [];
        foreach ($data as $userData) {
            $users[] = $this->userFactory->createFromData($userData);
        }

        return $users;
    }

    /**
     * @throws Exception|JsonException
     */
    public function findByEmail(string $email): ?User
    {
        $result = $this->connection->executeQuery(
            'SELECT user_id, roles, email, avatar_url, name, surname
             FROM auth_user
             WHERE email = :email',
            ['email' => $email],
        );

        $data = $result->fetchAssociative();

        if (false === $data) {
            return null;
        }

        return $this->userFactory->createFromData($data);
    }

    /**
     * @throws Exception
     */
    public function upsert(User $user): void
    {
        $this->connection->executeStatement(
            'INSERT INTO auth_user (user_id, email, roles, avatar_url, name, surname, updated_at)
             VALUES (:user_id, :email, :roles, :avatar_url, :name, :surname, :updated_at)
             ON CONFLICT (email) DO UPDATE SET
             avatar_url = :avatar_url, name = :name, surname = :surname, updated_at = :updated_at, roles = :roles',
            [
                'user_id' => $user->userId,
                'email' => $user->email,
                'roles' => $user->getRoles(),
                'avatar_url' => $user->avatar,
                'name' => $user->name,
                'surname' => $user->surname,
                'updated_at' => (new \DateTimeImmutable())->format(\DateTimeInterface::RFC3339_EXTENDED),
            ],
            [
                'user_id' => Types::GUID,
                'email' => Types::STRING,
                'roles' => Types::JSON,
                'avatar_url' => Types::STRING,
                'name' => Types::STRING,
                'surname' => Types::STRING,
            ],
        );
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function getById(UserId $userId): User
    {
        $user = $this->findById($userId);

        if (null === $user) {
            throw new \RuntimeException('User not found');
        }

        return $user;
    }
}
