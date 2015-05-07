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
 * @ORM\Table(name="dechet_plastique")
 * @ORM\Entity()
 */
class Plastique extends Dechet{

    function __construct()
    {
        $this->setCouleur('blue');
        $this->setLibelle('Plastique');
    }
} 