<?php

namespace Domain;

enum GroupType: string
{
    case Individual = 'individual';
    case Group = 'group';
    case Unknown = 'unknown';
}
