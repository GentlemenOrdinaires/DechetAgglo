<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\DechetSoin;
use GYG\AppBundle\Form\DechetSoinType;
use GYG\AppBundle\Entity\Localisation;
use Symfony\Component\Form\FormError;


class DechetSoinController extends Controller
{
    public function addAction(Request $request)
    {
        $dechetSoin = new DechetSoin();
        $form = $this->createForm(new DechetSoinType(), $dechetSoin);
        $user = $this->getUser();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $geojson = $request->request->get('gyg_appbundle_dechetsoin')['geojson'];
            if(!isset($geojson) || empty($geojson)) $form->addError(new FormError('Veuillez indiquez une position sur la carte'));
            else {
                $parseFromJsonService = $this->get('service_geo_json');
                $point = $parseFromJsonService->parseToPoint($geojson);
                $dechetSoin->setLocalisation(new Localisation($point));

                $em = $this->getDoctrine()->getManager();
                $em->persist($dechetSoin);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport de déchets de soins bien enregistré.');

                return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
            }
        }

        return $this->render('GYGAppBundle:_partials:form.html.twig', array(
            'form' => $form->createView(),
            'formTitle' => 'Ajouter un point d\'apport de dechets de soins',
            'formAction' => $this->generateUrl('gyg_app_edit_dechet_soin', array()),
            'dechet_soin' => $dechetSoin,
            'user' => $user
        ));
    }

    public function deleteAction($idDechetSoin, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dechetSoin = $em->getRepository('GYGAppBundle:DechetSoin')->find($idDechetSoin);

        if (!$dechetSoin) {
            throw $this->createNotFoundException('Point d\'apport de déchets de soins non trouvé');
        }

        $em->remove($dechetSoin);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport de déchets de soins bien supprimé.');

        return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
    }

    public function editAction($idDechetSoin, Request $request)
    {
        if($idDechetSoin == 0){
            return $this->addAction($request);
        } else {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $dechetSoin = $em->getRepository('GYGAppBundle:DechetSoin')->find($idDechetSoin);

            if (!$dechetSoin) {
                throw $this->createNotFoundException(
                    'Aucun point d\'apport de déchets de soins trouvé pour cet id : ' . $idDechetSoin
                );
            }

            $form = $this->createForm(new DechetSoinType(), $dechetSoin);


            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $geojson = $request->request->get('gyg_appbundle_dechetsoin')['geojson'];
                $parseFromJsonService = $this->get('service_geo_json');
                $point = $parseFromJsonService->parseToPoint($geojson);
                $dechetSoin->setLocalisation(new Localisation($point));

                $em->flush();
                return $this->redirect($this->generateUrl('gyg_app_adminpage'));
            }


            return $this->render('GYGAppBundle:_partials:form.html.twig', array(
                'form' => $form->createView(),
                'formTitle' => 'Editer un point d\'apport de dechets de soins',
                'formAction' => $this->generateUrl('gyg_app_edit_dechet_soin', array( 'idDechetSoin' => $dechetSoin->getId())),
                'elementToEdit' => $dechetSoin,
                'routeToApi' => 'gyg_app_api_dechet_soin',

                'user' => $user
            ));
        }
    }

}
