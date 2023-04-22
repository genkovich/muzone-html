<?php
declare(strict_types=1);


namespace Application\Admin\User;

use Domain\User\UserId;
use Domain\User\UserRepositoryInterface;

final readonly class ChangeUserFieldHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function handle(ChangeUserFieldCommand $changeUserFieldCommand): void
    {
        $user = $this->userRepository->getById(new UserId($changeUserFieldCommand->userId));
        $user = $user->withField($changeUserFieldCommand->field, $changeUserFieldCommand->value);
        $this->userRepository->upsert($user);
    }

}