<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 09:34
 */

namespace GYG\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Localisation
 * @package GYG\AppBundle\Entity
 * @ORM\Table(name="localisation")
 * @ORM\Entity(repositoryClass="Like\Repository\LikeRepository")
 *
 */
class Localisation {

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;


    /**
     * @var String @ORM\Column(name="latitude", type="string", length=255, nullable=false)
     */
    protected $latitude;

    /**
     * @var String @ORM\Column(name="longitude", type="string", length=255, nullable=false)
     */
    protected $longitude;

    function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param String $latitude
     * @return Localisation $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return String
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param String $longitude
     * @return Localisation $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }
} 