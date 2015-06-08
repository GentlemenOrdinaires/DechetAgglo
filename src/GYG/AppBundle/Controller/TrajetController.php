<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\Trajet;
use GYG\AppBundle\Form\TrajetType;
use Symfony\Component\Form\FormError;


class TrajetController extends Controller
{
    public function addAction(Request $request)
    {
        $trajet = new Trajet();
        $form = $this->createForm(new TrajetType(), $trajet);
        $user = $this->getUser();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $geojson = $request->request->get('gyg_appbundle_trajet')['geojson'];
            $jourCollecte = $request->request->get('gyg_appbundle_trajet')['jourCollecte'];
            $jourCollecteSelective = $request->request->get('gyg_appbundle_trajet')['jourCollecteSelective'];
            if(!isset($jourCollecteSelective) || empty($jourCollecteSelective)) $form->addError(new FormError('Veuillez indiquez des informations concernant les jours de collecte selective'));
            else if(!isset($jourCollecte) || empty($jourCollecte)) $form->addError(new FormError('Veuillez indiquez des informations concernant les jours de collecte'));
            else if(!isset($geojson) || empty($geojson)) $form->addError(new FormError('Veuillez indiquez une position sur la carte'));
            else {
                $parseFromJsonService = $this->get('service_geo_json');
                $localisations = $parseFromJsonService->parseToPoint($geojson);
                $trajet->setLocalisations($localisations);

                $em = $this->getDoctrine()->getManager();
                $em->persist($trajet);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Trajet bien enregistré.');

                return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
            }
        }

        return $this->render('GYGAppBundle:_partials:form_polygone.html.twig', array(
            'form' => $form->createView(),
            'formTitle' => 'Ajouter un trajet',
            'formAction' => $this->generateUrl('gyg_app_edit_trajet', array()),
            'trajet' => $trajet,
            'user' => $user
        ));
    }

    public function deleteAction($idTrajet, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $trajet = $em->getRepository('GYGAppBundle:Trajet')->find($idTrajet);

        if (!$trajet) {
            throw $this->createNotFoundException('Trajet non trouvé');
        }

        $em->remove($trajet);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Trajet bien supprimé.');

        return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
    }

    public function editAction($idTrajet, Request $request)
    {
        if($idTrajet == 0){
            return $this->addAction($request);
        } else {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $trajet = $em->getRepository('GYGAppBundle:Trajet')->find($idTrajet);

            if (!$trajet) {
                throw $this->createNotFoundException(
                    'Aucun trajet trouvé pour cet id : ' . $idTrajet
                );
            }

            $form = $this->createForm(new TrajetType(), $trajet);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $jourCollecteSelective = $trajet->getJourCollecteSelective();
                $jourCollecte = $trajet->getJourCollecte();
                if(!isset($jourCollecteSelective) || empty($jourCollecteSelective)) $form->addError(new FormError('Veuillez indiquez des informations concernant les jours de collecte selective'));
                else if(!isset($jourCollecte) || empty($jourCollecte)) $form->addError(new FormError('Veuillez indiquez des informations concernant les jours de collecte'));
                else {
                    $geojson = $request->request->get('gyg_appbundle_trajet')['geojson'];
                    $parseFromJsonService = $this->get('service_geo_json');
                    $localisations = $parseFromJsonService->parseToPoint($geojson);
                    $trajet->setLocalisations($localisations);

                    $em->flush();
                    return $this->redirect($this->generateUrl('gyg_app_adminpage'));
                }
            }

            return $this->render('GYGAppBundle:_partials:form_polygone.html.twig', array(
                'form' => $form->createView(),
                'formTitle' => 'Editer un trajet',
                'formAction' => $this->generateUrl('gyg_app_edit_trajet', array( 'idTrajet' => $trajet->getId())),
                'elementToEdit' => $trajet,
                'routeToApi' => 'gyg_app_api_trajet',
                'user' => $user
            ));
        }
    }

}
