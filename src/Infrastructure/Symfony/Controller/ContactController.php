<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller;

use Application\Contact\SaveContactCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ContactController extends AbstractController
{

    public function __construct(private readonly SaveContactHandler $handler)
    {
    }

    public function save(SaveContactCommand $command): Response
    {
        $this->handler->handle($command);

        return new JsonResponse(['message' => 'Contact saved'], Response::HTTP_CREATED);

    }

}