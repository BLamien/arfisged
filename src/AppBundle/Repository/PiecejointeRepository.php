<?php

namespace AppBundle\Repository;

/**
 * SortfinalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PiecejointeRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Nombre de type de document
     *
     * @author: Delrodie AMOIKON
     * @version: v1.0 04/06/2017
     */
    public function countTypeDocument($type)
    {
        $qb = $this->createQueryBuilder('d')
                   ->select('count(d.id)')
                   ->where('d.url LIKE :type')
                   ->setParameter('type', '%'.$type.'%')
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }
}
