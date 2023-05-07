<?php

declare(strict_types=1);

namespace Application\Admin\User;

final readonly class ChangeUserFieldCommand
{
    public function __construct(
        public string $userId,
        public string $field,
        public string $value,
    ) {
    }
}
