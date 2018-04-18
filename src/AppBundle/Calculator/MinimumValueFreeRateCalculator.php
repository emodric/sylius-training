<?php

namespace AppBundle\Calculator;

use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;

final class MinimumValueFreeRateCalculator implements CalculatorInterface
{
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        assert($subject instanceof \Sylius\Component\Core\Model\ShipmentInterface);

        if ($subject->getOrder()->getItemsTotal() < (int) $configuration['minimum']) {
            return (int) $configuration['default_rate'];
        }

        return 0;
    }

    public function getType(): string
    {
        return 'minimum_value_free_rate';
    }
}
