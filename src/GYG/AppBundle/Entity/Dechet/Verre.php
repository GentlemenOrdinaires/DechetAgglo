<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:26
 */

namespace GYG\AppBundle\Entity\Dechet;

use Doctrine\ORM\Mapping as ORM;
use GYG\AppBundle\Entity\Dechet;

/**
 * Class Verre
 * @package GYG\AppBundle\Entity\Dechet
 * @ORM\Entity()
 */
class Verre extends Dechet{
    const DISCRIMINATOR = 'verre';

    function __construct($pointApport)
    {
        parent::__construct($pointApport);
        $this->setCouleur('green');
        $this->setLibelle('Verre');
    }
}