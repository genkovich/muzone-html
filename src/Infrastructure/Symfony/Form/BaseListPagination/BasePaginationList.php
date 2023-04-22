<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Form\BaseListPagination;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasePaginationList extends AbstractType
{
    public const OPTION_HAS_PREV = 'has_prev';
    public const OPTION_HAS_NEXT = 'has_next';
    public const FORM_ELEMENT_OFFSET_NAME = 'offset';
    public const FORM_ELEMENT_PREV_NAME = 'prev';
    public const FORM_ELEMENT_NEXT_NAME = 'next';

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'method' => Request::METHOD_GET,
            ]
        );

        $resolver->setDefined(
            [
                self::OPTION_HAS_PREV,
                self::OPTION_HAS_NEXT,
            ]
        );

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::FORM_ELEMENT_OFFSET_NAME, HiddenType::class, $this->getOffsetOptions())
            ->add(self::FORM_ELEMENT_PREV_NAME, SubmitType::class, $this->getPrevOptions($options))
            ->add(self::FORM_ELEMENT_NEXT_NAME, SubmitType::class, $this->getNextOptions($options));
    }

    protected function isButtonDisabled(string $optionName, array $options): bool
    {
        return true === \array_key_exists($optionName, $options) && false === $options[$optionName];
    }


    protected function getPrevOptions(array $options): array
    {
        $buttonOptions = ['label' => 'Previous'];

        if (true === $this->isButtonDisabled(self::OPTION_HAS_PREV, $options)) {
            $buttonOptions['disabled'] = true;
        }

        return $buttonOptions;
    }

    protected function getNextOptions(array $options): array
    {
        $buttonOptions = ['label' => 'Next'];

        if (true === $this->isButtonDisabled(self::OPTION_HAS_NEXT, $options)) {
            $buttonOptions['disabled'] = true;
        }

        return $buttonOptions;
    }


    protected function getOffsetOptions(): array
    {
        return [
            'empty_data' => '0',
            'label' => false,
            'attr' => [
                'class' => 'hidden-field'
            ],
        ];
    }
}