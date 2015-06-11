<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\Decheterie;
use GYG\AppBundle\Form\DecheterieType;
use GYG\AppBundle\Entity\Localisation;
use Symfony\Component\Form\FormError;

class DecheterieController extends Controller
{
    public function addAction(Request $request)
    {
        $decheterie = new Decheterie();
        $form = $this->createForm(new DecheterieType(), $decheterie);
        $user = $this->getUser();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $geojson = $request->request->get('gyg_appbundle_decheterie')['geojson'];
            $horaires = $request->request->get('gyg_appbundle_decheterie')['horaires'];
            if(!isset($horaires) || empty($horaires)) $form->addError(new FormError('Veuillez indiquez des informations concernant les horaires'));
            else if(!isset($geojson) || empty($geojson)) $form->addError(new FormError('Veuillez indiquez une position sur la carte'));
            else {
                $parseFromJsonService = $this->get('service_geo_json');
                $point = $parseFromJsonService->parseToPoint($geojson);
                $decheterie->setLocalisation(new Localisation($point));

                $em = $this->getDoctrine()->getManager();
                $em->persist($decheterie);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Déchetterie bien enregistrée.');

                return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
            }

        }

        return $this->render('GYGAppBundle:_partials:form.html.twig', array(
            'form' => $form->createView(),
            'formTitle' => 'Ajouter une dechetterie',
            'formAction' => $this->generateUrl('gyg_app_edit_dechetterie', array()),
            'decheterie' => $decheterie,
            'user' => $user
        ));
    }

    public function deleteAction($idDecheterie, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $decheterie = $em->getRepository('GYGAppBundle:Decheterie')->find($idDecheterie);

        if (!$decheterie) {
            throw $this->createNotFoundException('Déchetterie non trouvée');
        }

        $em->remove($decheterie);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Déchetterie bien supprimée.');

        return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
    }

    public function editAction($idDecheterie, Request $request)
    {
        if($idDecheterie == 0){
           return $this->addAction($request);
        } else {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $decheterie = $em->getRepository('GYGAppBundle:Decheterie')->find($idDecheterie);

            if (!$decheterie) {
                throw $this->createNotFoundException(
                    'Aucune déchetterie trouvée pour cet id : ' . $idDecheterie
                );
            }

            $form = $this->createForm(new DecheterieType(), $decheterie);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $horaires = $decheterie->getHoraires();
                if(!isset($horaires) || empty($horaires)) $form->addError(new FormError('Veuillez indiquez des informations concernant les horaires'));
                else {
                    $geojson = $request->request->get('gyg_appbundle_decheterie')['geojson'];
                    $parseFromJsonService = $this->get('service_geo_json');
                    $point = $parseFromJsonService->parseToPoint($geojson);
                    $decheterie->setLocalisation(new Localisation($point));

                    $em->flush();
                    return $this->redirect($this->generateUrl('gyg_app_adminpage'));
                }
            }

            return $this->render('GYGAppBundle:_partials:form.html.twig', array(
                'form' => $form->createView(),
                'formTitle' => 'Editer une déchetterie',
                'formAction' => $this->generateUrl('gyg_app_edit_dechetterie', array('idDecheterie' => $decheterie->getId())),
                'elementToEdit' => $decheterie,
                'routeToApi' => 'gyg_app_api_dechetterie',
                'user' => $user
            ));
        }
    }

}
