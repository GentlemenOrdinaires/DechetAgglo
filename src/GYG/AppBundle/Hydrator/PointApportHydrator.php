<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 01/06/2015
 * Time: 14:20
 */

namespace GYG\AppBundle\Hydrator;


use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use GYG\AppBundle\Entity\PointApport;

class PointApportHydrator{


    /**
     * @param PointApport $pointApport
     */
    public function extract(PointApport $pointApport){

        $array = [];
        $array[$pointApport->getLocalisation()->getPoint()->getLatitude()] = $pointApport->getLocalisation()->getPoint()->getLongitude();

        return $array;
    }
}