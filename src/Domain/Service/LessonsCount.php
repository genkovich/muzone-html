<?php
declare(strict_types=1);


namespace Domain\Service;

final readonly class LessonsCount
{
    public function __construct(
        public int $lessonsCount,
    )
    {
        if ($this->lessonsCount < 0) {
            throw new \InvalidArgumentException('Lessons count cannot be less than 0');
        }
    }

    public function __toString(): string
    {
        return (string)$this->lessonsCount;
    }

}