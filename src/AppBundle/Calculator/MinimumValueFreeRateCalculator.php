<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;

final class MinimumValueFreeRateCalculator implements CalculatorInterface
{
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        if (!$subject instanceof \Sylius\Component\Core\Model\ShipmentInterface) {
            throw new \Exception('Invalid shippment!');
        }

        $order = $subject->getOrder();

        if (!$order instanceof OrderInterface) {
            throw new \Exception('Invalid shippment!');
        }

        $channelCode = $order->getChannel()->getCode();
        if ($subject->getOrder()->getItemsTotal() >= $configuration[$channelCode]['minimum']) {
            return 0;
        }

        return $configuration[$channelCode]['default_rate'];
    }

    public function getType(): string
    {
        return 'minimum_value_free_rate';
    }
}
