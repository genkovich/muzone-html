<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final readonly class JsonRequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->getContentTypeFormat() !== 'json' || !$request->getContent()) {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('Invalid JSON request body: ' . json_last_error_msg());
        }

        $request->request->replace(is_array($data) ? $data : []);
    }

}