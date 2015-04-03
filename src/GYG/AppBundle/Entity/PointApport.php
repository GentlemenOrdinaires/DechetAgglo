<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 10:48
 */

namespace GYG\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PointApport
 * @package GYG\AppBundle\Entity
 * @ORM\MappedSuperclass
 */
abstract class PointApport extends Mapable{

    /**
     * @var String  @ORM\Column(name="infos", type="string", length=255, nullable=true)
     */
    protected $infos;

    /**
     * @TODO
     * @var
     */
    protected $photo;

    /**
     * @TODO
     * @var
     */
    protected $logo;

    /**
     * @return String
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * @param String $infos
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;
    }

} 