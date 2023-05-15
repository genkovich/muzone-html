<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\ArgumentResolver\Service;

use Application\Admin\Service\ServiceCreateCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ServiceCreateCommandArgumentResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ServiceCreateCommand::class !== $argument->getType()) {
            return [];
        }

        yield new ServiceCreateCommand(
            $request->request->get('title'),
            (int)$request->request->get('price'),
            $request->request->get('currency'),
            $request->request->get('direction'),
            $request->request->get('age'),
            (int)$request->request->get('lessons_count'),
        );
    }
}