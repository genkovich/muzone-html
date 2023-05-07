<?php

declare(strict_types=1);

namespace Application\Lead\Notifier;

use Domain\Lead\Lead;

interface NotifierInterface
{
    public function notify(Lead $lead): void;
}
