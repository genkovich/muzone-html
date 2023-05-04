<?php
declare(strict_types=1);


namespace App\Tests\Sendpulse;

use Domain\Lead\Contact\Contact;
use Domain\Lead\Contact\ContactType;
use Domain\Lead\Contact\Value\Instagram;
use Domain\Lead\Lead;
use Domain\Lead\LeadId;
use Infrastructure\Sendpulse\Convertors\LeadToContactConvertor;
use Infrastructure\Sendpulse\Internal\Messenger;
use Infrastructure\Sendpulse\Internal\Responsible;
use PHPUnit\Framework\TestCase;

final  class LeadToContactConvertorTest extends TestCase
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

        $this->assertSame('example', $convertedContact->firstName);
        $this->assertSame('', $convertedContact->lastName);
        $this->assertSame('', $convertedContact->phone);
        $this->assertCount(1, $convertedContact->messengers);
        $this->assertSame(Messenger::Instagram->value, $convertedContact->messengers[0]['typeId']);
        $this->assertSame('example', $convertedContact->messengers[0]['login']);
        $this->assertSame(Responsible::Muzone->value, $convertedContact->responsibleId);
    }

}