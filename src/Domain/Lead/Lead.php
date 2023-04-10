<?php
declare(strict_types=1);


namespace Domain\Lead;

use Domain\Lead\Contact\Contact;

final readonly class Lead
{
    public function __construct(
        public LeadId $id,
        public Contact $contact,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }
}