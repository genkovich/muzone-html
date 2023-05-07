<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\ArgumentResolver;

use Application\Admin\User\ChangeUserFieldCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ChangeUserFieldArgumentResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ChangeUserFieldCommand::class !== $argument->getType()) {
            return [];
        }

        $userId = $request->request->get('user_id') ?? '';
        $field = $request->request->get('field') ?? '';
        $value = $request->request->get('value') ?? '';

        yield new ChangeUserFieldCommand((string) $userId, (string) $field, (string) $value);
    }
}
