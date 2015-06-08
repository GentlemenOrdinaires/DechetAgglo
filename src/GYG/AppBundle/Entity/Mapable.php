<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 10:35
 */

namespace GYG\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Mapable
 * @package GYG\AppBundle\Entity
 * @ORM\MappedSuperclass
 */
abstract class Mapable {

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var Localisation @ORM\OneToOne(targetEntity="GYG\AppBundle\Entity\Localisation", cascade={"persist"})
     * @ORM\JoinColumn(name="localisation_id", referencedColumnName="id")
     */
    protected $localisation;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Localisation
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param Localisation $localisation
     */
    public function setLocalisation(Localisation $localisation)
    {
        $this->localisation = $localisation;
    }


}
