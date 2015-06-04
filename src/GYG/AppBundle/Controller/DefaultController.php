<?php

namespace GYG\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GYGAppBundle:Default:index.html.twig', array('name' => $name));
    }

    public function adminAction()
    {
        $user = $this->getUser();
        return $this->render('GYGAppBundle:Admin:admin.html.twig', array(
            'user' => $user
        ));
    }

}
