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
            $dechets = [];
            foreach($_POST['gyg_appbundle_pointapport']['dechets'] as $key => $value){
                switch ($value){
                    case 'menager':
                        $dechets[] = new Menager();
                        break;
                    case 'metallique':
                        $dechets[] = new Metallique();
                        break;
                    case 'papierCarton':
                        $dechets[] = new PapierCarton();
                        break;
                    case 'plastique':
                        $dechets[] = new Plastique();
                        break;
                    case 'verre':
                        $dechets[] = new Verre();
                        break;
                }
            }
            $pointApportAerien->setDechets($dechets);

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
