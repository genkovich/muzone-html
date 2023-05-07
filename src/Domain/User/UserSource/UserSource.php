<?php

namespace Domain\User\UserSource;

final readonly class UserSource
{
    public function __construct(
        public Source $source,
        public string $externalId
    ) {
    }
}
