<?php

declare(strict_types=1);

namespace Infrastructure\Sendpulse\Internal;

enum PipelineId: int
{
    case Individual = 51858;

    case Group = 50685;
}
