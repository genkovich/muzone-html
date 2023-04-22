<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Form\BaseListPagination;

use DateTimeInterface;

class ListPagination
{
    public function __construct(
        private int $limit = 5,
        private int $offset = 0,
        private ?DateTimeInterface $fromDate = null,
        private ?DateTimeInterface $toDate = null,
    )
    {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getFromDate(): ?DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    public function setFromDate(?DateTimeInterface $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    public function getToDate(): ?DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(?DateTimeInterface $toDate): void
    {
        $this->toDate = $toDate;
    }

    public function processOffset(bool $increase = false, bool $decrease = false)
    {
        $limit = $this->getLimit();
        $offset = $this->getOffset();

        $newOffset = $offset;
        if (true === $increase) {
            $newOffset = $offset + $limit;
        }
        if (true === $decrease) {
            $newOffset = $offset - $limit;
        }
        if (0 > $newOffset) {
            $newOffset = 0;
        }

        $this->setOffset($newOffset);

        return $this;
    }

}