<?php

declare(strict_types=1);

namespace App\Tests\Sendpulse\LeadToContactConvertor;

use Infrastructure\Sendpulse\Convertors\LeadToContactConvertor;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ExtractTelegramUsernameTest extends TestCase
{
    private LeadToContactConvertor $converter;

    protected function setUp(): void
    {
        $this->converter = new LeadToContactConvertor();
    }

    /**
     * @dataProvider telegramUsernameProvider
     */
    public function testExtractTelegramUsername(string $input, string $expected): void
    {
        $result = $this->converter->extractTelegramUsername($input);
        static::assertSame($expected, $result);
    }

    public function telegramUsernameProvider(): array
    {
        return [
            ['https://t.me/example', 'example'],
            ['https://telegram.me/example', 'example'],
            ['@example', 'example'],
            ['example', 'example'],
        ];
    }

    /**
     * @dataProvider telegramUsernameNegativeProvider
     */
    public function testExtractTelegramUsernameNegative(string $input): void
    {
        $result = $this->converter->extractTelegramUsername($input);
        static::assertNotSame('example', $result);
    }

    public function telegramUsernameNegativeProvider(): array
    {
        return [
            ['https://telegra.me/example'],
            ['https://telegra.com/example'],
            ['https://telegramm.me/example'],
            ['https://t.mme/example'],
            ['https://t.meexample'],
            ['https://t.mecom/example'],
            ['https:/t.me/example'],
            ['http//t.me/example'],
            ['@'],
            [''],
        ];
    }
}
