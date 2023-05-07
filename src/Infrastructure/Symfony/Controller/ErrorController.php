<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ErrorController extends AbstractController
{
    public function show(int $statusCode): Response
    {
        return $this->render('exception/error404.html.twig', [
            'statusCode' => $statusCode, new Response('', Response::HTTP_NOT_FOUND),
        ]);
    }
}
