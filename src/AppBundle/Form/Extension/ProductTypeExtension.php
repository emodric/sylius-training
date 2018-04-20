<?php

namespace AppBundle\Form\Extension;

use AppBundle\Entity\Supplier;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('supplier', ResourceAutocompleteChoiceType::class, [
            'label' => 'app.ui.supplier',
            'multiple' => false,
            'required' => false,
            'choice_name' => 'name',
            'choice_value' => 'code',
            'resource' => 'app.supplier',
        ]);
    }

    public function getExtendedType()
    {
        return ProductType::class;
    }
}
