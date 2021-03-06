<?php

namespace ER\CantineBundle\Repository;

/**
 * CourseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CourseRepository extends \Doctrine\ORM\EntityRepository {

    public function findSomme() {
        $query = $this->_em->createQuery("SELECT SUM(c.prix) FROM ERCantineBundle:Course c");
        $somme = $query
                ->getSingleScalarResult();
        return $somme;
    }

    public function findSommeBetweenTwoDate($date1, $date2) {

        $query = $this->_em->createQuery("SELECT SUM(c.prix) FROM ERCantineBundle:Course c WHERE c.datecourse BETWEEN :date1 and :date2");
        $query->setParameter('date1', $date1);
        $query->setParameter('date2', $date2);
        $somme = $query
                ->getSingleScalarResult();

        return $somme;
    }
    
    
    

}
