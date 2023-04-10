<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\ArgumentResolver;


use Application\Lead\SaveLeadCommand;
use Domain\Lead\Contact\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class SaveLeadCommandArgumentResolver  implements ValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return SaveLeadCommand::class === $argument->getType();
    }

    /**
     * @throws \Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {

        $phone = $request->request->get('your_phone');
        $telegram = $request->request->get('your_telegram');
        $viber = $request->request->get('your_viber');

        if ($phone) {
            $contactType = ContactType::Phone;
            $contactValue = $phone;
        } elseif ($telegram) {
            $contactType = ContactType::Telegram;
            $contactValue = $telegram;
        } elseif ($viber) {
            $contactType = ContactType::Instagram;
            $contactValue = $viber;
        } else {
            throw new \RuntimeException('Contact type not found');
        }


        // Валидация данных здесь (если требуется)

        yield new SaveLeadCommand($contactValue, $contactType->value);
    }
}