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

    /**
     * @var ArrayCollection @ORM\OneToMany(
     *      targetEntity="GYG\AppBundle\Entity\Dechet",
     *      mappedBy="pointApport",
     *      cascade={"all"})
     */
    protected $dechets;

    /**
     * @return ArrayCollection
     */
    public function getDechets()
    {
        return $this->dechets;
    }

    /**
     * @param Dechet $dechet
     */
    public function addDechet(Dechet $dechet)
    {
        $this->dechets->add($dechet);
    }

    /**
     * @param Dechet $dechet
     */
    public function removeDechet(Dechet $dechet)
    {
        $this->dechets->remove($dechet);
    }

    /**
     * @param ArrayCollection $dechets
     */
    public function setDechets($dechets)
    {
        $this->dechets = $dechets;
    }
} 