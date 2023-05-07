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
final class ExtractInstagramUsernameTest extends TestCase
{
    private LeadToContactConvertor $converter;

    protected function setUp(): void
    {
        $this->converter = new LeadToContactConvertor();
    }

    /**
     * @dataProvider instagramUsernameProvider
     */
    public function testExtractInstagramUsername(string $input, string $expected): void
    {
        $result = $this->converter->extractInstagramUsername($input);
        static::assertSame($expected, $result);
    }

    public function instagramUsernameProvider(): array
    {
        return [
            ['https://www.instagram.com/example', 'example'],
            ['https://instagram.com/example', 'example'],
            ['http://www.instagram.com/example', 'example'],
            ['@example', 'example'],
            ['example', 'example'],
        ];
    }

    /**
     * @dataProvider instagramUsernameNegativeProvider
     */
    public function testExtractInstagramUsernameNegative(string $input): void
    {
        $result = $this->converter->extractInstagramUsername($input);
        static::assertNotSame('example', $result);
    }

    public function instagramUsernameNegativeProvider(): array
    {
        return [
            ['https://www.instagra.com/example'],
            ['https://instagra.com/example'],
            ['https://instagramm.com/example'],
            ['https://www.instagram.comexample'],
            ['https://www.instagramcom/example'],
            ['http//www.instagram.com/example'],
            ['@'],
            [''],
        ];
    }
}
