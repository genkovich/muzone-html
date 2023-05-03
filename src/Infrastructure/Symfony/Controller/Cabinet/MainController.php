<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller\Cabinet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final  class MainController extends AbstractController
{
    public function dashboard(): Response
    {
        return new JsonResponse('cabinet');
    }

}