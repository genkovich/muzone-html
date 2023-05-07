<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller;

use Domain\User\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AdminController extends AbstractController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function dashboard(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'admin/dashboard.html.twig',
            [
                'user' => $user,
            ],
        );
    }

    public function setSidebarState(Request $request): Response
    {
        $state = $request->request->get('sidebar_state');
        $session = $request->getSession();
        $session->set('sidebarState', $state);

        return $this->json(['message' => 'Sidebar state updated']);
    }
}
