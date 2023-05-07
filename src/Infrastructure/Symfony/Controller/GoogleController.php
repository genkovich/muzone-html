<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class GoogleController extends AbstractController
{
    public function connectGoogleStart(ClientRegistry $clientRegistry): Response
    {
        $defaultScope = $defaultOptions = [];

        return $clientRegistry->getClient('google')->redirect($defaultScope, $defaultOptions);
    }

    public function connectCheckAction(UrlGeneratorInterface $urlGenerator): Response
    {
        return new RedirectResponse($urlGenerator->generate('admin.dashboard'));
    }
}
