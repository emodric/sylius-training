<?php

namespace AppBundle\EventListener;

use Sylius\Component\Core\Factory\PromotionActionFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PromotionInterface;
use Sylius\Component\Core\Repository\PromotionRepositoryInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\Promotion\Generator\PromotionCouponGeneratorInstruction;
use Sylius\Component\Promotion\Generator\PromotionCouponGeneratorInterface;
use Sylius\Component\Resource\Factory\Factory;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

final class OrderFinishedCouponGeneratorListener
{
    private const ORDER_PLACED_PROMOTION = 'ORDER_PLACED_PROMOTION';

    /** @var FactoryInterface */
    private $factory;

    /** @var PromotionRepositoryInterface */
    private $repository;

    /** @var PromotionCouponGeneratorInterface */
    private $promotionCouponGenerator;

    /** @var PromotionActionFactoryInterface */
    private $promotionActionFactory;

    /** @var SenderInterface */
    private $sender;

    public function __construct(
        FactoryInterface $factory,
        PromotionRepositoryInterface $repository,
        PromotionActionFactoryInterface $promotionActionFactory,
        PromotionCouponGeneratorInterface $promotionCouponGenerator,
        SenderInterface $sender
    ) {
        $this->factory = $factory;
        $this->promotionCouponGenerator = $promotionCouponGenerator;
        $this->repository = $repository;
        $this->promotionActionFactory = $promotionActionFactory;
        $this->sender = $sender;
    }

    public function sendCoupon(GenericEvent $event): void
    {
        $order = $event->getSubject();

        if (!$order instanceof OrderInterface) {
            return;
        }
        $promotion = $this->providePromotion($order);


        $generatorInstruction = new PromotionCouponGeneratorInstruction();
        $generatorInstruction->setAmount(1);
        $generatorInstruction->setUsageLimit(1);

        $this->repository->add($promotion);

        $coupons = $this->promotionCouponGenerator->generate($promotion, $generatorInstruction);
        $coupon = array_pop($coupons);

        $this->sender->send('coupon_email', [$order->getCustomer()->getEmail()], ['order' => $order, 'coupon' => $coupon]);
    }

    private function providePromotion(OrderInterface $order): PromotionInterface
    {
        $promotion = $this->repository->findOneBy(['code' => self::ORDER_PLACED_PROMOTION]);

        if ($promotion !== null) {
            return $promotion;
        }

        /** @var PromotionInterface $promotion */
        $promotion = $this->factory->createNew();

        $channel = $order->getChannel();

        $promotion->setName('Order placed promotion');
        $promotion->setCode(self::ORDER_PLACED_PROMOTION);
        $promotion->setCouponBased(true);
        $promotion->addChannel($channel);
        $promotion->addAction($this->promotionActionFactory->createFixedDiscount(500, $channel->getCode()));

        return $promotion;
    }
}
