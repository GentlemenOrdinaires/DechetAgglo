<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 06/05/2015
 * Time: 12:01
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PointApportRepository extends EntityRepository{

    public function findByLocation(Location $location){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('pa');
        $qb->from('GYGAppBundle/Entity/PointApport');


    }
}