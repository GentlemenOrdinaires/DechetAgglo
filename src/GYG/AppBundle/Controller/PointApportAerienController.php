<?php

namespace GYG\AppBundle\Controller;

use GYG\AppBundle\Entity\Dechet\Menager;
use GYG\AppBundle\Entity\Dechet\Metallique;
use GYG\AppBundle\Entity\Dechet\PapierCarton;
use GYG\AppBundle\Entity\Dechet\Plastique;
use GYG\AppBundle\Entity\Dechet\Verre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GYG\AppBundle\Entity\PointApport\Aerien;
use GYG\AppBundle\Form\PointApportType;
use Symfony\Component\HttpFoundation\Request;

class PointApportAerienController extends Controller
{
    public function addAction(Request $request)
    {
        $pointApportAerien = new Aerien();
        $form = $this->createForm(new PointApportType(), $pointApportAerien);

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
            $em->persist($pointApportAerien);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport aerien bien enregistré.');

            return $this->redirect($this->generateUrl('admin', array()));
        }

        return $this->render('GYGAppBundle:PointApport:form_point_apport.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
