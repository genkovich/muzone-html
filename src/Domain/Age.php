<?php

namespace Domain;

enum Age: string
{
    case Kids = 'kids';
    case Adult = 'adult';
    case Unknown = 'unknown';

}
