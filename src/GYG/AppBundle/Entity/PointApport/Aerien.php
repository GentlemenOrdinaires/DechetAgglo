<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 14:52
 */

namespace GYG\AppBundle\Entity\PointApport;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use GYG\AppBundle\Entity\PointApport;

/**
 * Class Aerien
 * @package GYG\AppBundle\Entity
 * @ORM\Entity()
 */
class Aerien extends PointApport
{

    const DISCRIMINATOR = 'aerien';

} 