<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 09:34
 */

namespace GYG\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GYG\AppBundle\ValueObject\Point;

/**
 * Class Localisation
 * @package GYG\AppBundle\Entity
 * @ORM\Table(name="localisation")
 * @ORM\Entity()
 *
 */
class Localisation
{
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="point")
     *
     * @var Point
     */
    protected $point;

    /**
     * @var string @ORM\Column(type="string")
     */
    protected $address;

    public function __construct(Point $point, $address)
    {
        $this->address = $address;
        $this->point = $point;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param mixed $point
     */
    public function setPoint(Point $point)
    {
        $this->point = $point;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

} 