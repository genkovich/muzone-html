<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller\Admin;

use Application\Admin\User\ChangeUserFieldCommand;
use Application\Admin\User\ChangeUserFieldHandler;
use Domain\User\UserId;
use Domain\User\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final  class UserController extends AbstractController
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly ChangeUserFieldHandler $changeUserFieldHandler,
    )
    {
    }

    public function singleUser(string $id): Response
    {
        $user = $this->userRepository->getById(new UserId($id));

        return $this->render(
            'admin/single_user.html.twig',
            [
                'user' => $user,
            ],
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function updateUserField(ChangeUserFieldCommand $changeUserFieldCommand): Response
    {
        $this->changeUserFieldHandler->handle($changeUserFieldCommand);

        return new JsonResponse(['id' => $changeUserFieldCommand->userId], Response::HTTP_OK);
    }

    public function users(): Response
    {
        $users = $this->userRepository->getList();

        return $this->render(
            'admin/users.html.twig',
            [
                'users' => $users,
            ],
        );
    }

}