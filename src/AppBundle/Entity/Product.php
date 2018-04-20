<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Supplier;

class Product extends \Sylius\Component\Core\Model\Product
{
    /** @var Supplier|null */
    private $supplier;

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): void
    {
        $this->supplier = $supplier;
    }
}
