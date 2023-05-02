<?php

namespace Domain;

enum GroupType: string
{
    case Individual = 'individual';
    case Group = 'group';
    case Unknown = 'unknown';

    public function icon(): string
    {
        return match ($this) {
            self::Individual => '🧍',
            self::Group => '🧑‍🤝‍🧑',
            default => '?',
        };
    }
}
