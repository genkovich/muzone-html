<?php

declare(strict_types=1);

namespace Domain\Management\Student;

final readonly class Profile
{
    public function __construct(
        public ProfileId $id,
        public string $firstName,
        public string $lastName,
        public string $middleName,
        public array $contacts,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    )
    {
    }

}