<?php

namespace ER\CantineBundle\Repository;

/**
 * CourseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CourseRepository extends \Doctrine\ORM\EntityRepository
{
    public function findSomme(){
        $dql = "SELECT SUM(c.prix) FROM ER\CantineBundle\Entity\Course c";
        $somme = $this->_em->createQuery($dql)
              ->getSingleScalarResult();
    return $somme;
    }
    
    public function findSommeBetweenTwoDate($date1,$date2){
        
        $dql = "SELECT SUM(c.prix) FROM ER\CantineBundle\Entity\Course c
                 where c.datecourse between '$date1' and '$date2'";
        $somme = $this->_em->createQuery($dql)
              ->getSingleScalarResult();
            return $somme;
     }
    
    

}
