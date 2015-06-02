<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 06/05/2015
 * Time: 12:01
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use GYG\AppBundle\ValueObject\Point;

class PointApportRepository extends EntityRepository
{

    /**
     * @param Point $point
     */
    public function findByPoint(Point $point)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('pa');
        $queryBuilder->from('GYG\AppBundle\Entity\PointApport','pa');
        //TODO filtre par location
        $queryBuilder->getQuery()->execute();
    }
}