<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Form\BaseListPagination;

use Symfony\Component\Form\Extension\Core\DataMapper\DataMapper;

class PaginationDataMapper extends DataMapper
{
    /**
     * @psalm-suppress ParamNameMismatch, InvalidArgument
     */
    public function mapFormsToData(iterable $forms, &$data): void
    {
        // @var \Traversable $forms
        parent::mapFormsToData($forms, $data);

        if (null === $data) {
            return;
        }

        $forms = \iterator_to_array($forms);

        $data->processOffset(
            $forms['next']->isClicked(),
            $forms['prev']->isClicked()
        );
    }
}
