<?php

namespace Domain;

enum Age: string
{
    case Kids = 'kids';

    case Adult = 'adult';

    case Unknown = 'unknown';

    public function icon(): string
    {
        return match ($this) {
            self::Kids => '👶',
            self::Adult => '🧑',
            default => '?',
        };
    }
}
