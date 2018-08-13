<?php

declare(strict_types=1);

namespace AppBundle\Form\Type;

use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MinimumValueFreeConfigurationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['currency']);
        $resolver->setAllowedTypes('currency', ['string']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('minimum', MoneyType::class, ['currency' => $options['currency']]);
        $builder->add('default_rate', MoneyType::class, ['currency' => $options['currency']]);
    }
}
