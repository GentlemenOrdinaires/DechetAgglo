<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:07
 */

use Doctrine\ORM\Mapping as ORM;
use GYG\AppBundle\Entity\Mapable;
use GYG\AppBundle\Entity\PointApport;

/**
 * Class Textile
 * @package GYG\AppBundle\Entity
 * @ORM\Entity()
 */
class Textile extends Mapable
{

    /**
     * @var String  @ORM\Column(name="infos", type="string", length=255, nullable=true)
     */
    protected $infos;




} 