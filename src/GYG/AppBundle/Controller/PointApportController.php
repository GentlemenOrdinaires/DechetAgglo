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
use Symfony\Component\Form\FormError;


class PointApportController extends Controller
{
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new PointApportType());
        $user = $this->getUser();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $geojson = $request->request->get('gyg_appbundle_pointapport')['geojson'];
            $dechets = isset($request->request->get('gyg_appbundle_pointapport')['dechets']) ? $request->request->get('gyg_appbundle_pointapport')['dechets'] : [];
            if(!isset($geojson) || empty($geojson)) $form->addError(new FormError('Veuillez indiquez une position sur la carte'));
            else if(!isset($dechets) || empty($dechets)) $form->addError(new FormError('Veuillez selectionnez au moins un type de dechet'));
            else {
                $className = 'GYG\AppBundle\Entity\PointApport\\' . ucfirst($request->request->get('gyg_appbundle_pointapport')['type']);
                $pointApport = new $className;

                foreach ($dechets as $key => $value) {
                    switch ($value) {
                        case 'menager':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Menager')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Menager')->findOneBy([])) : $pointApport->addDechet(new Menager());
                            break;
                        case 'metallique':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Metallique')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Metallique')->findOneBy([])) : $pointApport->addDechet(new Metallique());
                            break;
                        case 'papier-carton':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\PapierCarton')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\PapierCarton')->findOneBy([])) : $pointApport->addDechet(new PapierCarton());
                            break;
                        case 'plastique':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Plastique')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Plastique')->findOneBy([])) : $pointApport->addDechet(new Plastique());
                            break;
                        case 'verre':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Verre')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Verre')->findOneBy([])) : $pointApport->addDechet(new Verre());
                            break;
                    }
                }

                $pointApport->setInfos($request->request->get('gyg_appbundle_pointapport')['infos']);
                $pointApport->setFilePhoto($request->files->get('gyg_appbundle_pointapport')['filePhoto']);

                $parseFromJsonService = $this->get('service_geo_json');
                $point = $parseFromJsonService->parseToPoint($geojson);
                $pointApport->setLocalisation(new Localisation($point));

                $em = $this->getDoctrine()->getManager();
                $em->persist($pointApport);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport bien enregistré.');

                return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
            }
        }

        return $this->render('GYGAppBundle:_partials:form.html.twig', array(
            'form' => $form->createView(),
            'formTitle' => 'Ajouter un point d\'apport',
            'formAction' => $this->generateUrl('gyg_app_edit_point_apport', array()),
            'user' => $user
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
        } else {
            $user = $this->getUser();
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

                foreach ($request->request->get('gyg_appbundle_pointapport')['dechets'] as $key => $value) {
                    switch ($value) {
                        case 'menager':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Menager')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Menager')->findOneBy([])): $pointApport->addDechet(new Menager());
                            break;
                        case 'metallique':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Metallique')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Metallique')->findOneBy([])): $pointApport->addDechet(new Metallique());
                            break;
                        case 'papier-carton':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\PapierCarton')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\PapierCarton')->findOneBy([])): $pointApport->addDechet(new PapierCarton());
                            break;
                        case 'plastique':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Plastique')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Plastique')->findOneBy([])): $pointApport->addDechet(new Plastique());
                            break;
                        case 'verre':
                            $em->getRepository('GYG\AppBundle\Entity\Dechet\Verre')->findOneBy([]) ? $pointApport->addDechet($em->getRepository('GYG\AppBundle\Entity\Dechet\Verre')->findOneBy([])): $pointApport->addDechet(new Verre());
                            break;
                    }
                }

                if(empty($pointApport)) $form->addError(new FormError('Veuillez selectionnez au moins un type de dechet'));
                else {
                    $pointApport->setInfos($request->request->get('gyg_appbundle_pointapport')['infos']);
                    $pointApport->setFilePhoto($request->files->get('gyg_appbundle_pointapport')['filePhoto']);

                    $em->persist($pointApport->getDechets());
                    $em->flush();

                    return $this->redirect($this->generateUrl('gyg_app_adminpage'));
                }
            }

            return $this->render('GYGAppBundle:_partials:form.html.twig', array(
                'form' => $form->createView(),
                'formTitle' => 'EDITER UN POINT D\'APPORT',
                'formAction' => $this->generateUrl('gyg_app_edit_point_apport', array('idPointApport' => $pointApport->getId())),
                'pointApport' => $pointApport,
                'user' => $user
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
