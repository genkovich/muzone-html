<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller;

use Application\Lead\SaveLeadCommand;
use Application\Lead\SaveLeadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class LeadController extends AbstractController
{

    public function __construct(private readonly SaveLeadHandler $handler)
    {
    }

    public function save(SaveLeadCommand $command): Response
    {
        $this->handler->handle($command);

        return new JsonResponse(['message' => 'Lead saved'], Response::HTTP_CREATED);

    }

}