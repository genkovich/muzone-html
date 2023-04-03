<?php
declare(strict_types=1);


namespace Application\Contact;

use Domain\Contact\Contact;
use Domain\Contact\ContactRepositoryInterface;

final readonly class SaveContactHandler
{
    public function __construct(private ContactRepositoryInterface $contactRepository) {}

    public function handle(SaveContactCommand $command): void
    {
        $contact = new Contact(
            $command->phone,
            $command->telegram,
            $command->viber
        );

        $this->contactRepository->save($contact);
    }

}