<?php

declare(strict_types=1);

namespace AppBundle\Repository\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class SupplierRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function findByPhrase(string $phrase): array
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        return $this->createQueryBuilder('o')
            ->andWhere($expr->orX(
                'o.name LIKE :phrase',
                'o.code LIKE :phrase'
            ))
            ->setParameter('phrase', '%' . $phrase . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
