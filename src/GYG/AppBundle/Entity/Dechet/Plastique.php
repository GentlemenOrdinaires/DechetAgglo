<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:27
 */

namespace GYG\AppBundle\Entity\Dechet;

use GYG\AppBundle\Entity\Dechet;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Plastique
 * @package GYG\AppBundle\Entity\Dechet
 * @ORM\Entity()
 */
class Plastique extends Dechet
{
    const DISCRIMINATOR = 'plastique';
} 