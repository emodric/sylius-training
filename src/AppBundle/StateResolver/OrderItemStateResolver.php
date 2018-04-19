<?php

namespace AppBundle\StateResolver;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

use SM\Factory\FactoryInterface as StateMachineFactoryInterface;

final class OrderItemStateResolver
{
    /** @var StateMachineFactoryInterface */
    private $factory;

    public function __construct(StateMachineFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function resolve(OrderInterface $order)
    {
        foreach ($order->getItems() as $item) {
            $stateMachine = $this->factory->get($item, 'app_order_item');
            $stateMachine->apply('create');
        }
    }
}
