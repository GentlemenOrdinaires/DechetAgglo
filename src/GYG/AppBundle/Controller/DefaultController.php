<?php

namespace GYG\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GYGAppBundle:Default:index.html.twig', array(

        ));
    }

    public function adminAction()
    {

        return $this->render('GYGAppBundle:Admin:admin.html.twig', array(
        ));
    }

}
