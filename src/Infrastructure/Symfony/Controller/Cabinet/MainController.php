<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller\Cabinet;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final  class MainController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger,
    )
    {
    }

    public function dashboard(): Response
    {
        $this->logger->error('Test Monolog error');

        throw new \RuntimeException('TestErrorException');
        return new JsonResponse('ok');
    }

}