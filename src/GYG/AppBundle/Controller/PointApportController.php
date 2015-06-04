<?php

namespace GYG\AppBundle\Controller;

use GYG\AppBundle\Entity\Dechet\Menager;
use GYG\AppBundle\Entity\Dechet\Metallique;
use GYG\AppBundle\Entity\Dechet\PapierCarton;
use GYG\AppBundle\Entity\Dechet\Plastique;
use GYG\AppBundle\Entity\Dechet\Verre;
use GYG\AppBundle\Entity\Localisation;
use GYG\AppBundle\Entity\PointApport;
use GYG\AppBundle\Form\PointApportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
                    case 'papier-carton':
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

            $parseFromJsonService = $this->get('service_geo_json');
            $point = $parseFromJsonService->parseToPoint($request->request->get('gyg_appbundle_pointapport')['geojson']);
            $pointApport->setLocalisation(new Localisation($point));

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

    public function editAction($idPointApport, Request $request)
    {
        if($idPointApport == 0){
            return $this->addAction($request);
        }else{
            $em = $this->getDoctrine()->getManager();
            $pointApport = $em->getRepository('GYGAppBundle:PointApport')->find($idPointApport);

            if (!$pointApport) {
                throw $this->createNotFoundException(
                    'Aucun point d\'apport trouvé pour cet id : ' . $idPointApport
                );
            }

            $dechets = $this->getDechets($pointApport);

            $form = $this->createForm(new PointApportType());
            $form->get('infos')->setData($pointApport->getInfos());
            $form->get('dechets')->setData($dechets);
            $form->get('type')->setData($pointApport::DISCRIMINATOR);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $query = "UPDATE point_apport SET discriminator = '".$request->request->get('gyg_appbundle_pointapport')['type']."' WHERE id = ".$pointApport->getId();
                $em->getConnection()->exec( $query );

                $dechets = [];
                foreach ($request->request->get('gyg_appbundle_pointapport')['dechets'] as $key => $value) {
                    switch ($value) {
                        case 'menager':
                            $dechets[] = new Menager($pointApport);
                            break;
                        case 'metallique':
                            $dechets[] = new Metallique($pointApport);
                            break;
                        case 'papier-carton':
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

                $em->persist($pointApport);
                $em->flush();

                return $this->redirect($this->generateUrl('gyg_app_adminpage'));
            }

            return $this->render('GYGAppBundle:PointApport:form_point_apport.html.twig', array(
                'form' => $form->createView(),
                'pointApport' => $pointApport
            ));
        }

    }

    private function getDechets($pointApport){
        $dechets = [];
        foreach($pointApport->getDechets() as $key => $value){
            $dechets[] = $value::DISCRIMINATOR;
        }

        return $dechets;
    }
}
