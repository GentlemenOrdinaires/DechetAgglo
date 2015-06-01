<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:25
 */

namespace GYG\AppBundle\Entity\Dechet;

use Doctrine\ORM\Mapping as ORM;
use GYG\AppBundle\Entity\Dechet;

/**
 * Class PapierCarton
 * @package GYG\AppBundle\Entity\Dechet
 * @ORM\Entity()
 */
class PapierCarton extends Dechet {
    const DISCRIMINATOR = 'papier-carton';

    function __construct($pointApport)
    {
        parent::__construct($pointApport);
        $this->setCouleur('brown');
        $this->setLibelle('Papiers/Cartons');
    }
} 