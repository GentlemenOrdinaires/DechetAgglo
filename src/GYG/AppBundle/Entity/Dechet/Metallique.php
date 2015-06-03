<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 01/04/2015
 * Time: 15:27
 */

namespace GYG\AppBundle\Entity\Dechet;

use Doctrine\ORM\Mapping as ORM;
use GYG\AppBundle\Entity\Dechet;

/**
 * Class Metallique
 * @package GYG\AppBundle\Entity\Dechet
 * @ORM\Entity()
 */
class Metallique extends Dechet{
    const DISCRIMINATOR = 'metallique';

    function __construct()
    {
        $this->setCouleur('grey');
        $this->setLibelle('Déchets métalliuqes');
    }
}