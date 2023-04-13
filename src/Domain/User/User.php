<?php

declare(strict_types=1);

namespace Domain\User;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements \JsonSerializable, UserInterface
{
    public function __construct(
        public readonly UserId $userId,
        public readonly string $email,
        public readonly string $avatar,
        public readonly string $name,
        public readonly string $surname,
        private array $roles,
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

    public function changeRoles(UserRole ...$roles): self
    {
        $user = clone $this;
        $user->roles = $roles;

        return $user;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
