<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:27
 */

namespace GYG\AppBundle\Entity\Dechet;

use Doctrine\ORM\Mapping as ORM;
use GYG\AppBundle\Entity\Dechet;

/**
 * Class Menager
 * @package GYG\HAppBundle\Entity\Dechet
 * @ORM\Entity()
 */
class Menager extends Dechet{
    const DISCRIMINATOR = 'menager';

    function __construct()
    {
        $this->setLibelle('Déchets ménagers');
    }
} 