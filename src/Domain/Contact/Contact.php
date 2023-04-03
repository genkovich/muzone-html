<?php
declare(strict_types=1);


namespace Domain\Contact;

final readonly class Contact
{
    public function __construct(
        public string $phone,
        public string $telegram,
        public string $viber
    ) {}

}