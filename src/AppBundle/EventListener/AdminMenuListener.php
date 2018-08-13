<?php

declare(strict_types=1);

namespace AppBundle\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class AdminMenuListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return array('sylius.menu.admin.main' => 'addSupplierToMenu');
    }

    public function addSupplierToMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $supplierSubmenu = $menu
            ->addChild('supplier')
            ->setLabel('Supplier');

        $supplierSubmenu
            ->addChild('supplier_index', [
                'route' => 'app_admin_supplier_index',
            ])
            ->setLabel('Manage suppliers')
            ->setLabelAttribute('icon', 'sliders');

    }
}
