<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 10:37
 */

namespace GYG\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Decheterie
 * @package GYG\AppBundle\Entity
 * @ORM\Table(name="decheterie")
 * @ORM\Entity()
 */
class Decheterie extends Mapable{

    /**
     * @var String  @ORM\Column(name="couleur", type="string", length=255, nullable=false)
     */
    protected $horaires;

    /**
     * @var String  @ORM\Column(name="infos", type="string", length=255, nullable=true)
     */
    protected $infos;

    /**
     * @return String
     */
    public function getHoraires()
    {
        return $this->horaires;
    }

    /**
     * @param String $horaires
     */
    public function setHoraires($horaires)
    {
        $this->horaires = $horaires;
    }

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