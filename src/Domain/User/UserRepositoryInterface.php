<?php

declare(strict_types=1);

namespace Domain\User;

interface UserRepositoryInterface
{
    public function nextIdentity(): UserId;

    public function findById(UserId $userId): ?User;

    public function getById(UserId $userId): User;

    public function findByEmail(string $email): ?User;

    public function upsert(User $user): void;

    /**
     * @return User[]
     */
    public function getList(int $limit, int $offset): array;
}
