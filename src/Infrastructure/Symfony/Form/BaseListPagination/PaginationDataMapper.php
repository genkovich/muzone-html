<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Form\BaseListPagination;

use Symfony\Component\Form\Extension\Core\DataMapper\DataMapper;

class PaginationDataMapper extends DataMapper
{
    public function mapFormsToData($forms, &$viewData): void
    {
        parent::mapFormsToData($forms, $viewData);

        if (null === $viewData) {
            return;
        }

        $forms = \iterator_to_array($forms);

        $viewData->processOffset(
            $forms['next']->isClicked(),
            $forms['prev']->isClicked()
        );
    }
}
