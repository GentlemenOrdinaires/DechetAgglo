<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 10:48
 */

namespace GYG\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PointApport
 * @package GYG\AppBundle\Entity
 * @ORM\Table(name="point_apport")
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"aerien" = "GYG\AppBundle\Entity\PointApport\Aerien",
 * "enterre" = "GYG\AppBundle\Entity\PointApport\Enterre"})
 * @ORM\HasLifecycleCallbacks
 */
abstract class PointApport extends Mapable
{

    /**
     * @var String  @ORM\Column(name="infos", type="string", length=255, nullable=true)
     */
    protected $infos;

    /**
     * @var String  @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    protected $photo;

    /**
     * @var String  @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    protected $logo;

    /**
     * @Assert\Image(maxSize="5M")
     */
    protected $fileLogo;

    /**
     * @Assert\Image(maxSize="5M")
     */
    protected $filePhoto;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(
     *      targetEntity="GYG\AppBundle\Entity\Dechet",
     *      cascade={"persist"}, inversedBy="dechet")
     * @ORM\JoinTable(name="point_apport_dechet",
     *      joinColumns={@ORM\JoinColumn(name="point_apport_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="dechet_id", referencedColumnName="id")}
     *      )
     */
    protected $dechets;

    public function __construct(){
        $this->dechets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getFilePhoto()
    {
        return $this->filePhoto;
    }

    /**
     * @param mixed $filePhoto
     */
    public function setFilePhoto($filePhoto)
    {
        $this->filePhoto = $filePhoto;
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

    /**
     * @return mixed
     */
    public function getFileLogo()
    {
        return $this->fileLogo;
    }

    /**
     * @param mixed $fileLogo
     */
    public function setFileLogo($fileLogo)
    {
        $this->fileLogo = $fileLogo;
    }


    /**
     * @ORM\PostUpdate()
     * @ORM\PostPersist()
     */
    public function upload()
    {
        // if no files
        if ($this->filePhoto == null) return;

        $this->filePhoto->move(
            $this->getUploadRootDir(),
            $this->photo
        );
        $this->filePhoto = null;
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function preUpload()
    {
        if ($this->filePhoto == null) return;

        // generate a unique name
        $filename = sha1(uniqid(mt_rand(), true));
        $this->photo = $filename . '.' . $this->filePhoto->guessExtension();
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public function getUploadRootDir()
    {
        return __DIR__ . '../../../../../web/' . $this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/pointapport';
    }

    public function getAbsolutePath()
    {
        return null === $this->photo ? null : $this->getUploadRootDir() . '/' . $this->photo;
    }

    public function getWebPath()
    {
        return null === $this->photo ? null : $this->getUploadDir() . '/' . $this->photo;
    }


    /**
     * @return ArrayCollection
     */
    public function getDechets()
    {
        return $this->dechets;
    }

    /**
     * @param Dechet $dechet
     */
    public function addDechet($dechet)
    {
        $this->dechets->add($dechet);
    }

    /**
     * @param Dechet $dechet
     */
    public function removeDechet($dechet)
    {
        $this->dechets->remove($dechet);
    }

    /**
     * @param ArrayCollection $dechets
     */
    public function setDechets($dechets)
    {
        $this->dechets = $dechets;
    }

} 