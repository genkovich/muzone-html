<?php
declare(strict_types=1);


namespace Application\Contact;

final readonly class SaveContactCommand
{
    public function __construct(
        public string $phone,
        public string $telegram,
        public string $viber
    ) {}

}