<?php

namespace GYG\AppBundle\Controller;

use GYG\AppBundle\Entity\Dechet\Menager;
use GYG\AppBundle\Entity\Dechet\Metallique;
use GYG\AppBundle\Entity\Dechet\PapierCarton;
use GYG\AppBundle\Entity\Dechet\Plastique;
use GYG\AppBundle\Entity\Dechet\Verre;
use GYG\AppBundle\Entity\PointApport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Form\PointApportType;
use Symfony\Component\HttpFoundation\Request;

class PointApportController extends Controller
{
    public function addAction(Request $request)
    {
        $form = $this->createForm(new PointApportType());

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $className = 'GYG\AppBundle\Entity\PointApport\\'.ucfirst($request->request->get('gyg_appbundle_pointapport')['type']);
            $pointApport = new $className;

            $dechets = [];
            foreach($request->request->get('gyg_appbundle_pointapport')['dechets'] as $key => $value){
                switch ($value){
                    case 'menager':
                        $dechets[] = new Menager($pointApport);
                        break;
                    case 'metallique':
                        $dechets[] = new Metallique($pointApport);
                        break;
                    case 'papierCarton':
                        $dechets[] = new PapierCarton($pointApport);
                        break;
                    case 'plastique':
                        $dechets[] = new Plastique($pointApport);
                        break;
                    case 'verre':
                        $dechets[] = new Verre($pointApport);
                        break;
                }
            }

            $pointApport->setDechets($dechets);
            $pointApport->setInfos($request->request->get('gyg_appbundle_pointapport')['infos']);
            $pointApport->setFilePhoto($request->files->get('gyg_appbundle_pointapport')['filePhoto']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($pointApport);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport bien enregistré.');

            return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
        }

        return $this->render('GYGAppBundle:PointApport:form_point_apport.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($idPointApport, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pointApport = $em->getRepository('GYGAppBundle:PointApport')->find($idPointApport);

        if (!$pointApport) {
            throw $this->createNotFoundException('Point d\'apport non trouvé');
        }

        $em->remove($pointApport);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport bien supprimé.');

        return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
    }

    public function listAction(){
        $em = $this->getDoctrine()->getManager();
        $pointApports = $em->getRepository('GYGAppBundle:PointApport')->findAll();

        if (!$pointApports) {
            throw $this->createNotFoundException('Aucun point d\'apport trouvé');
        }

        return $this->render('GYGAppBundle:PointApport:list_point_apport.html.twig', array(
            'pointApports' => $pointApports
        ));
    }

}
