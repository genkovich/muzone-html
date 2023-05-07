<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Psql\User;

use Domain\User\User;
use Domain\User\UserId;

final class UserFactory
{
    private const FIELD_USER_ID = 'user_id';
    private const FIELD_EMAIL = 'email';
    private const FIELD_AVATAR_URL = 'avatar_url';
    private const FIELD_NAME = 'name';
    private const FIELD_SURNAME = 'surname';
    private const FIELD_ROLES = 'roles';

    /**
     * @throws \JsonException
     */
    public function createFromData(array $data): User
    {
        $roles = json_decode((string) $data[self::FIELD_ROLES], true, 512, JSON_THROW_ON_ERROR);

        return new User(
            userId: new UserId($data[self::FIELD_USER_ID]),
            email: $data[self::FIELD_EMAIL],
            avatar: $data[self::FIELD_AVATAR_URL],
            name: $data[self::FIELD_NAME],
            surname: $data[self::FIELD_SURNAME],
            roles: $roles,
            createdAt: new \DateTimeImmutable($data['created_at']),
            updatedAt: new \DateTimeImmutable($data['updated_at']),
        );
    }
}
