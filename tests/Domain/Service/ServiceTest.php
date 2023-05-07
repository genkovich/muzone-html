<?php

declare(strict_types=1);

namespace App\Tests\Domain\Service;

use Domain\Age;
use Domain\Common\Currency;
use Domain\Direction;
use Domain\Service\LessonsCount;
use Domain\Service\Price;
use Domain\Service\Service;
use Domain\Service\ServiceId;
use Domain\Service\Title;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 *
 * @coversNothing
 */
final class ServiceTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    public function testServiceCreation(): void
    {
        $serviceId = new ServiceId(Uuid::v4()->toRfc4122());
        $title = new Title($this->faker->sentence(3));
        $price = new Price(
            $this->faker->numberBetween(100, 10000),
            Currency::tryFrom($this->faker->randomElement(['UAH', 'USD', 'EUR']))
        );
        $direction = $this->faker->randomElement([
            Direction::Guitar,
            Direction::Drums,
            Direction::Saxophone,
            Direction::Vocal,
        ]);
        $lessonsCount = new LessonsCount($this->faker->numberBetween(1, 10));
        $age = $this->faker->randomElement([
            Age::Adult,
            Age::Kids,
        ]);
        $createdAt = \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 month'));
        $updatedAt = \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($createdAt->getTimestamp()));

        $service = new Service(
            $serviceId,
            $title,
            $price,
            $direction,
            $lessonsCount,
            $age,
            $createdAt,
            $updatedAt
        );

        static::assertSame($serviceId, $service->serviceId);
        static::assertSame($title, $service->title);
        static::assertSame($price, $service->price);
        static::assertSame($direction, $service->direction);
        static::assertSame($lessonsCount, $service->lessonsCount);
        static::assertSame($age, $service->age);
        static::assertSame($createdAt, $service->createdAt);
        static::assertSame($updatedAt, $service->updatedAt);
    }
}
