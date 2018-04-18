<?php

namespace AppBundle\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addSupplierToMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $supplierSubmenu = $menu
            ->getChild('catalog')
        ;

        $supplierSubmenu
            ->addChild('supplier_index', [
                'route' => 'app_admin_supplier_index',
            ])
            ->setLabel('Manage Suppliers')
            ->setLabelAttribute('icon', 'sliders')
            ->setLabelAttribute('color', 'blue')
        ;
    }
}