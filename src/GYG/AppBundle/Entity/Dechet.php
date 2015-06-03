<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 14:57
 */

namespace GYG\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Dechet
 * @package GYG\AppBundle\Entity
 * @ORM\Table(name="dechet")
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"menager" = "GYG\AppBundle\Entity\Dechet\Menager",
 * "metallique" = "GYG\AppBundle\Entity\Dechet\Metallique",
 * "papier-carton" = "GYG\AppBundle\Entity\Dechet\PapierCarton",
 * "plastique" = "GYG\AppBundle\Entity\Dechet\Plastique",
 * "verre" = "GYG\AppBundle\Entity\Dechet\Verre"})
 *
 */

abstract class Dechet
{
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    protected $id;

    /**
     * @var String @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    protected $libelle;


    /**
     * @TODO
     * @var
     */
    protected $photo;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param String $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return mixed
     */
    public function getPointApport()
    {
        return $this->pointApport;
    }

    /**
     * @param mixed $pointApport
     */
    public function setPointApport($pointApport)
    {
        $this->pointApport = $pointApport;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }



    /**
     * Override toString() method to return the name of the group
     * @return string name
     */
    public function __toString()
    {
        return $this->libelle;
    }

} 