<?php

declare(strict_types=1);

namespace Domain;

enum Age: string
{
    case Kids = 'kids';

    case Adult = 'adult';

    case Unknown = 'unknown';

    public static function all(): array
    {
        return [
            self::Kids,
            self::Adult,
        ];
    }

    public function icon(): string
    {
        return match ($this) {
            self::Kids => '👶',
            self::Adult => '🧑',
            default => '?',
        };
    }
}
