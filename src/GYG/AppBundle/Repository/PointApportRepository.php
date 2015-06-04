<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 06/05/2015
 * Time: 12:01
 */

namespace GYG\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GYG\AppBundle\Entity\Dechet;
use GYG\AppBundle\Entity\PointApport;
use GYG\AppBundle\ValueObject\Point;
use Proxies\__CG__\GYG\AppBundle\Entity\Trajet;

class PointApportRepository extends EntityRepository
{

    /**
     * @param Point $point
     */
    public function findByPoint(Point $point)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('pa');
        $queryBuilder->from('GYG\AppBundle\Entity\PointApport', 'pa');
        //TODO filtre par location
        $queryBuilder->getQuery()->execute();
    }

    /**
     * @param $type
     */
    public function findByDechetType($type)
    {
        $entities = $this->findAll();
        $array = [];
        foreach ($entities as $pointApport) {
            if ($pointApport instanceof PointApport) {
                foreach ($pointApport->getDechets() as $dechet) {
                    if ($dechet instanceof Dechet && $dechet::DISCRIMINATOR == $type) {
                        $array[] = $pointApport;
                        continue;
                    }
                }
            }
        }
        return $array;
    }
}