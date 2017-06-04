<?php

namespace AppBundle\Repository;

/**
 * DocumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DocumentRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Requête de recherche
     *
     * @author: Delrodie AMOIKON
     * @version: v1.0 04/06/2017 14:48
     */
    public function recherche($mot)
    {
        $qb = $this->createQueryBuilder('d')
                   ->addSelect('r')
                   ->addSelect('s')
                   ->join('d.rubrique', 'r')
                   ->join('d.sortfinal', 's')
                   ->where('d.libelle LIKE :mot')
                   ->orWhere('d.resume LIKE :mot')
                   ->orWhere('d.tags LIKE :mot')
                   ->orWhere('d.dateprod LIKE :mot')
                   ->orWhere('d.datefin LIKE :mot')
                   ->orWhere('d.reference LIKE :mot')
                   ->orWhere('r.libelle LIKE :mot')
                   ->orWhere('s.libelle LIKE :mot')
                   ->setParameter('mot', '%'.$mot.'%')
                   ->orderBy('d.libelle', 'ASC')
        ;
        return $qb->getQuery()->getResult();
    }

    /**
     * Nombe de document par rubrique
     *
     * @author: Delrodie AMOIKON
     * @version: v1.0 04/06/2017 19:29
     */
    public function countDocumentByRubrique($rubrique)
    {
        $qb = $this->createQueryBuilder('d')
                   ->select('count(d.id)')
                   ->where('d.rubrique = :rubrique')
                   ->setParameter('rubrique', $rubrique)
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }
}
