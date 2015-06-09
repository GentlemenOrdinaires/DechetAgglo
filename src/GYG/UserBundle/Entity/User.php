<?php
/**
 * Created by PhpStorm.
 * User: yassir
 * Date: 26/04/2015
 * Time: 13:40
 */

namespace GYG\UserBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->setRoles(['ROLE_ADMIN']);
    }
}