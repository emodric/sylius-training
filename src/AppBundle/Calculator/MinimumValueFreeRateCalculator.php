<?php

namespace AppBundle\Calculator;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;

final class MinimumValueFreeRateCalculator implements CalculatorInterface
{
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        assert($subject instanceof \Sylius\Component\Core\Model\ShipmentInterface);

        $order = $subject->getOrder();

        assert($order instanceof OrderInterface);

        $channelCode = $order->getChannel()->getCode();
        if ($subject->getOrder()->getItemsTotal() < (int) $configuration[$channelCode]['minimum']) {
            return (int) $configuration[$channelCode]['default_rate'];
        }

        return 0;
    }

    public function getType(): string
    {
        return 'minimum_value_free_rate';
    }
}
