<?php
declare(strict_types=1);


namespace Infrastructure\Persistence\Psql\Repository;

use Domain\Contact\Contact;
use Domain\Contact\ContactRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class ContactRepository implements ContactRepositoryInterface
{
    public function __construct(
        private Connection $connection
    )
    {
    }

    /**
     * @throws Exception
     */
    public function save(Contact $contact): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('contacts')
            ->values([
                'phone' => ':phone',
                'telegram' => ':telegram',
                'viber' => ':viber',
            ])
            ->setParameters([
                'phone' => $contact->phone,
                'telegram' => $contact->telegram,
                'viber' => $contact->viber,
            ])
            ->executeStatement();
    }
}