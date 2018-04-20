<?php

namespace AppBundle\Form\Extension;

use AppBundle\Entity\Supplier;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('supplier', EntityType::class, [
            'class' => Supplier::class,
            'choice_label' => 'name',
            'choice_value' => 'code',
        ]);
    }

    public function getExtendedType()
    {
        return ProductType::class;
    }
}
