<?php
declare(strict_types=1);


namespace Domain\Contact;

interface ContactRepositoryInterface
{
    public function save(Contact $contact): void;
}