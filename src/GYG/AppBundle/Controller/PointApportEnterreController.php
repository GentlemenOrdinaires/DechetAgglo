<?php

namespace GYG\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GYG\AppBundle\Entity\PointApport\Enterre;
use GYG\AppBundle\Form\PointApportType;
use Symfony\Component\HttpFoundation\Request;

class PointApportEnterreController extends Controller
{
    public function addAction(Request $request)
    {
        $pointApportEnterre = new Enterre();
        $form = $this->createForm(new PointApportType(), $pointApportEnterre);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pointApportEnterre);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport enterre bien enregistré.');

            return $this->redirect($this->generateUrl('admin', array()));
        }

        return $this->render('GYGAppBundle:PointApport:form_point_apport.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
