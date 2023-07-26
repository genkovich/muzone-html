<?php
declare(strict_types=1);


namespace Domain\Management\Student;

interface ProfileRepositoryInterface
{
    public function nextIdentity(): ProfileId;

    public function findById(ProfileId $userId): ?Profile;

    public function upsert(Profile $user): void;

    /**
     * @return Profile[]
     */
    public function getList(int $limit = 10, int $offset = 0): array;

}