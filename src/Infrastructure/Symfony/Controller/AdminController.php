<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class AdminController extends AbstractController
{
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
}