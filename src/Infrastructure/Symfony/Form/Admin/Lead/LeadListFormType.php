<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Form\Admin\Lead;

use Infrastructure\Symfony\Form\BaseListPagination\ListFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @psalm-suppress MissingTemplateParam */
final class LeadListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('search', SearchType::class, [
            'required' => false,
            'label' => false,
            'row_attr' => [
                'class' => 'input-group',
            ],
            'attr' => [
                'placeholder' => 'Search',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LeadPaginationList::class,
        ]);
    }

    public function getParent(): string
    {
        return ListFormType::class;
    }
}
