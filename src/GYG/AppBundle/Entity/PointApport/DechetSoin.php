<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:08
 */

namespace GYG\AppBundle\Entity\PointApport;

use Doctrine\ORM\Mapping as ORM;
use GYG\AppBundle\Entity\PointApport;

/**
 * Class DechetSoin
 * @package GYG\AppBundle\Entity
 * @ORM\Entity()
 */
class DechetSoin extends PointApport
{
    const DISCRIMINATOR = 'dechet-soin';

} 