<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\ArgumentResolver;


use Application\Contact\SaveContactCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class SaveContactCommandArgumentResolver  implements ValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return SaveContactCommand::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $phone = $request->request->get('your_phone');
        $telegram = $request->request->get('your_telegram');
        $viber = $request->request->get('your_viber');

        // Валидация данных здесь (если требуется)

        yield new SaveContactCommand($phone, $telegram, $viber);
    }
}