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
 * @ORM\Table(name="point_apport")
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"aerien" = "GYG\AppBundle\Entity\PointApport\Aerien",
 * "enterre" = "GYG\AppBundle\Entity\PointApport\Enterre",
 * "dechet-soin" = "GYG\AppBundle\Entity\PointApport\DechetSoin",
 * "textile" = "GYG\AppBundle\Entity\PointApport\Textile"})
 */
abstract class PointApport extends Mapable
{

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
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }



} 