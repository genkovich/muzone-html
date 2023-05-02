<?php

namespace Domain;

enum Direction: string
{
    case Drums = 'drums';
    case Vocal = 'vocal';
    case Guitar = 'guitar';
    case Piano = 'piano';
    case Ukulele = 'ukulele';
    case Saxophone = 'saxophone';
    case Certificate = 'certificate';
    case Other = 'other';
    case Unknown = 'unknown';

    public function icon(): string
    {
        return match ($this) {
            self::Drums => '🥁',
            self::Vocal => '🎤',
            self::Guitar => '🎸',
            self::Piano => '🎹',
            self::Ukulele => '🪕',
            self::Saxophone => '🎷',
            self::Certificate => '📜',
            default => '?',
        };
    }

}
