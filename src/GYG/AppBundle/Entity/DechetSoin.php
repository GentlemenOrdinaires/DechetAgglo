<?php
/**
 * Created by PhpStorm.
 * User: Guillaume Prost (hello@guillaumeprost.me)
 * Date: 01/04/2015
 * Time: 15:08
 */
namespace GYG\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class DechetSoin
 * @package GYG\AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="dechet_soin")
 * @ORM\HasLifecycleCallbacks
 */
class DechetSoin extends Mapable
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
     * @Assert\Image(maxSize="5M")
     */
    protected $filePhoto;

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
     * @return String
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param String $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
     * @ORM\PostUpdate()
     * @ORM\PostPersist()
     */
    public function upload(){
        // if no files
        if($this->filePhoto == null) return;

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
    public function preUpload(){
        if($this->filePhoto == null) return;

        // generate a unique name
        $filename = sha1(uniqid(mt_rand(), true));
        $this->photo = $filename.'.'.$this->filePhoto->guessExtension();
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

    public function getUploadRootDir() {
        return __DIR__.'../../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir() {
        return 'uploads/dechet_soin';
    }

    public function getAbsolutePath() {
        return null === $this->photo ? null : $this->getUploadRootDir().'/'.$this->photo;
    }

    public function getWebPath() {
        return null === $this->photo ? null : $this->getUploadDir().'/'.$this->photo;
    }
} 