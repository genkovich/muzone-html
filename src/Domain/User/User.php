<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Common\Cloneable;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class User extends Cloneable implements \JsonSerializable, UserInterface
{
    public function __construct(
        public UserId $userId,
        public string $email,
        public string $avatar,
        public string $name,
        public string $surname,
        public array $roles,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }

    #[ArrayShape([
        'user_id' => 'string',
        'email' => 'string',
        'avatar' => 'string',
        'name' => 'string',
        'surname' => 'string',
        'roles' => 'array',
    ])]
    public function jsonSerialize(): array
    {
        return [
            'user_id' => (string)$this->userId,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'name' => $this->name,
            'surname' => $this->surname,
            'roles' => $this->roles,
        ];
    }


    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}
