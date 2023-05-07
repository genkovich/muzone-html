<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Form\BaseListPagination;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ListFormType extends AbstractType
{
    private PaginationDataMapper $mapper;

    public function __construct()
    {
        $this->mapper = new PaginationDataMapper();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setDataMapper($this->mapper)
            ->add('fromDate', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'required' => false,
                'row_attr' => [
                    'class' => 'input-group',
                ],
                'attr' => [
                    'placeholder' => 'From',
                ],
            ])
            ->add('toDate', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'required' => false,
                'row_attr' => [
                    'class' => 'input-group',
                ],
                'attr' => [
                    'placeholder' => 'To',
                ],
            ])
            ->add('limit', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    '5' => 5,
                    '10' => 10,
                    '25' => 25,
                    '50' => 50,
                ],
                'row_attr' => [
                    'class' => 'input-group',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListPagination::class,
            'csrf_protection' => false,
            'method' => Request::METHOD_GET,
        ]);
    }

    public function getParent(): string
    {
        return BasePaginationList::class;
    }
}
