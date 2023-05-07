<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Form\Admin\Lead;

use Infrastructure\Symfony\Form\BaseListPagination\ListPagination;

final class LeadPaginationList extends ListPagination
{
    public function __construct(
        int $limit = 5,
        int $offset = 0,
        ?\DateTimeInterface $fromDate = null,
        ?\DateTimeInterface $toDate = null,
        private ?string $search = null
    ) {
        parent::__construct($limit, $offset, $fromDate, $toDate);
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }
}
