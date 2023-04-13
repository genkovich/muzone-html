<?php
declare(strict_types=1);


namespace Domain\User\UserSource;

enum Source: string
{
    case Google = 'google';
}