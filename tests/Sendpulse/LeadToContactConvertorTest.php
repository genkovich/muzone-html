<?php

declare(strict_types=1);

namespace App\Tests\Sendpulse;

use Domain\Common\Contact\Contact;
use Domain\Common\Contact\ContactType;
use Domain\Common\Contact\Value\Instagram;
use Domain\Lead\Lead;
use Domain\Lead\LeadId;
use Infrastructure\Sendpulse\Convertors\LeadToContactConvertor;
use Infrastructure\Sendpulse\Internal\Messenger;
use Infrastructure\Sendpulse\Internal\Responsible;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class LeadToContactConvertorTest extends TestCase
{
    public function testConvert(): void
    {
        $leadId = new LeadId('21c9d949-2c3d-4e79-9362-d5acad099f0e');
        $createdAt = new \DateTimeImmutable();
        $updatedAt = new \DateTimeImmutable();

        $lead = new Lead(
            id: $leadId,
            contact: new Contact(
                type: ContactType::Instagram,
                value: new Instagram('example')
            ),
            lessonsCount: 5,
            direction: null,
            groupType: null,
            age: null,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            telegramSentAt: null,
            sendpulseSentAt: null
        );

        $converter = new LeadToContactConvertor();
        $convertedContact = $converter->convert($lead);

        static::assertSame('example', $convertedContact->firstName);
        static::assertSame('', $convertedContact->lastName);
        static::assertSame(0, $convertedContact->phone);
        static::assertCount(1, $convertedContact->messengers);
        static::assertSame(Messenger::Instagram->value, $convertedContact->messengers[0]['typeId']);
        static::assertSame('example', $convertedContact->messengers[0]['login']);
        static::assertSame(Responsible::Muzone->value, $convertedContact->responsibleId);
    }
}
