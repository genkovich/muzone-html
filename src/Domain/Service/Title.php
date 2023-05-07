<?php

declare(strict_types=1);

namespace Domain\Service;

final readonly class Title
{
    public function __construct(
        public string $title,
    ) {
        if (empty($this->title)) {
            throw new \InvalidArgumentException('Service title cannot be empty');
        }

        if (\mb_strlen($this->title) > 255) {
            throw new \InvalidArgumentException('Service title cannot be longer than 255 characters');
        }

        if (\mb_strlen($this->title) < 3) {
            throw new \InvalidArgumentException('Service title cannot be less than 3 characters');
        }
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
