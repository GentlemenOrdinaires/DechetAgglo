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
 * @ORM\MappedSuperclass
 */
abstract class Dechet {
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var String @ORM\Column(name="couleur", type="string", length=255, nullable=true)
     */
    protected $couleur;

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
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * @param String $couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
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

} 