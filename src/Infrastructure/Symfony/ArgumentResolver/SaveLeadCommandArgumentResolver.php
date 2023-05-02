<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\ArgumentResolver;


use Application\Lead\SaveLeadCommand;
use Domain\Lead\Contact\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class SaveLeadCommandArgumentResolver implements ValueResolverInterface
{

    /**
     * @throws \Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (SaveLeadCommand::class !== $argument->getType()) {
            return [];
        }

        $phone = $request->request->get('your_phone');
        $telegram = $request->request->get('your_telegram');
        $instagram = $request->request->get('your_instagram');

        $lessonsCount = $request->request->get('count');
        $direction = $request->request->get('direction');
        $groupType = $request->request->get('group_type');
        $age = $request->request->get('age');

        if ($phone) {
            $contactType = ContactType::Phone;
            $contactValue = $phone;
        } elseif ($telegram) {
            $contactType = ContactType::Telegram;
            $contactValue = $telegram;
        } elseif ($instagram) {
            $contactType = ContactType::Instagram;
            $contactValue = $instagram;
        } else {
            throw new \RuntimeException('Contact type not found');
        }

        yield new SaveLeadCommand(
            $contactValue,
            $contactType->value,
            (int) $lessonsCount,
            (string) $direction,
            (string) $groupType,
            (string) $age,
        );
    }
}