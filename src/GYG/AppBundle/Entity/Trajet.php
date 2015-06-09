<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 09:51
 */

namespace GYG\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Trajet
 * @package GYG\AppBundle\Entity
 * @ORM\Table(name="trajet")
 * @ORM\Entity()
 */
class Trajet {

    /**
     *
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(
     *      targetEntity="GYG\AppBundle\Entity\Localisation",
     *      cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="trajets_localisations",
     *      joinColumns={@ORM\JoinColumn(name="trajet_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="localisation_id", referencedColumnName="id", unique=true, onDelete="CASCADE")}
     *      )
     */
    protected $localisations;

    /**
     * Couleur du trajet
     *
     * @var String @ORM\Column(name="couleur", type="string", length=255, nullable=false)
     */
    protected $couleur;

    /**
     * @var String @ORM\Column(name="jour_collecte", type="string", length=255, nullable=false)
     */
    protected $jourCollecte;

    /**
     * @var String @ORM\Column(name="jour_collecte_selective", type="string", length=255, nullable=false)
     */
    protected  $jourCollecteSelective;


    public function __construct(){
        $this->localisations = new ArrayCollection();
    }

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
    public function getJourCollecte()
    {
        return $this->jourCollecte;
    }

    /**
     * @param String $jourCollecte
     */
    public function setJourCollecte($jourCollecte)
    {
        $this->jourCollecte = $jourCollecte;
    }

    /**
     * @return String
     */
    public function getJourCollecteSelective()
    {
        return $this->jourCollecteSelective;
    }

    /**
     * @param String $jourCollecteSelective
     */
    public function setJourCollecteSelective($jourCollecteSelective)
    {
        $this->jourCollecteSelective = $jourCollecteSelective;
    }

    /**
     * @return ArrayCollection
     */
    public function getLocalisations()
    {
        return $this->localisations;
    }

    /**
     * @param Localisation $localisation
     * @return Trajet $this
     */
    public function addLocalisation(Localisation $localisation){
        $this->localisations->add($localisation);
        return $this;
    }

    /**
     * @param Localisation $localisation
     */
    public function removeLocalisation(Localisation $localisation){
        $this->localisations->remove($localisation);
    }

    /**
     * @param ArrayCollection $localisations
     */
    public function setLocalisations(ArrayCollection $localisations)
    {
        $this->localisations = $localisations;
    }
} 