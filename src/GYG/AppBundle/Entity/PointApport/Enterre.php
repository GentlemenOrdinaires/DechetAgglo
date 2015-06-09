<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:05
 */

namespace GYG\AppBundle\Entity\PointApport;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use GYG\AppBundle\Entity\PointApport;

/**
 * Class Enterre
 * @package GYG\AppBundle\Entity
 * @ORM\Entity()
 */
class Enterre extends PointApport
{

    const DISCRIMINATOR = 'enterre';

} 