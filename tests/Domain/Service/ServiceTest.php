<?php

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

class ServiceTest extends TestCase
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

        $this->assertSame($serviceId, $service->serviceId);
        $this->assertSame($title, $service->title);
        $this->assertSame($price, $service->price);
        $this->assertSame($direction, $service->direction);
        $this->assertSame($lessonsCount, $service->lessonsCount);
        $this->assertSame($age, $service->age);
        $this->assertSame($createdAt, $service->createdAt);
        $this->assertSame($updatedAt, $service->updatedAt);

    }
}
