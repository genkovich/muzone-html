<?php
declare(strict_types=1);


namespace Infrastructure\Persistence\Psql\Management\Client\Profile;

use Domain\Management\Student\Profile;
use Domain\Management\Student\ProfileId;
use Domain\Management\Student\ProfileRepositoryInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class ProfileRepository implements ProfileRepositoryInterface
{
    public function __construct(
        private UuidFactory $uuidGenerator,
        private Connection $connection,
        private ProfileFactory $profileFactory,
    ) {
    }

    public function nextIdentity(): ProfileId
    {
        $uuid = $this->uuidGenerator->create();

        return new ProfileId((string) $uuid);
    }

    public function findById(ProfileId $userId): ?Profile
    {
        // TODO: Implement findById() method.
    }

    public function upsert(Profile $user): void
    {
        // TODO: Implement upsert() method.
    }

    public function getList(int $limit = 10, int $offset = 0): array
    {
        // TODO: Implement getList() method.
    }
}