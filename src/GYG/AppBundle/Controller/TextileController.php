<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\Textile;
use GYG\AppBundle\Form\TextileType;
use GYG\AppBundle\Entity\Localisation;
use Symfony\Component\Form\FormError;


class TextileController extends Controller
{
    public function addAction(Request $request)
    {
        $textile = new Textile();
        $form = $this->createForm(new TextileType(), $textile);
        $user = $this->getUser();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $geojson = $request->request->get('gyg_appbundle_textile')['geojson'];
            if(!isset($geojson) || empty($geojson)) $form->addError(new FormError('Veuillez indiquez une position sur la carte'));
            else {
                $parseFromJsonService = $this->get('service_geo_json');
                $point = $parseFromJsonService->parseToPoint($geojson);
                $textile->setLocalisation(new Localisation($point));

                $em = $this->getDoctrine()->getManager();
                $em->persist($textile);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport textile bien enregistré.');

                return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
            }
        }

        return $this->render('GYGAppBundle:_partials:form.html.twig', array(
            'form' => $form->createView(),
            'formTitle' => 'Ajouter un point d\'apport textile',
            'formAction' => $this->generateUrl('gyg_app_edit_textile', array()),
            'textile' => $textile,
            'user' => $user
        ));
    }

    public function deleteAction($idTextile, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $textile = $em->getRepository('GYGAppBundle:Textile')->find($idTextile);

        if (!$textile) {
            throw $this->createNotFoundException('Point d\'apport textile non trouvé');
        }

        $em->remove($textile);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport textile bien supprimé.');

        return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
    }

    public function editAction($idTextile, Request $request)
    {
        if($idTextile == 0){
            return $this->addAction($request);
        } else {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $textile = $em->getRepository('GYGAppBundle:Textile')->find($idTextile);

            if (!$textile) {
                throw $this->createNotFoundException(
                    'Aucun point d\'apport textile trouvé pour cet id : ' . $idTextile
                );
            }

            $form = $this->createForm(new TextileType(), $textile);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $geojson = $request->request->get('gyg_appbundle_textile')['geojson'];
                $parseFromJsonService = $this->get('service_geo_json');
                $point = $parseFromJsonService->parseToPoint($geojson);
                $textile->setLocalisation(new Localisation($point));

                $em->flush();
                return $this->redirect($this->generateUrl('gyg_app_adminpage'));
            }

            return $this->render('GYGAppBundle:_partials:form.html.twig', array(
                'form' => $form->createView(),
                'formTitle' => 'Editer un point d\'apport textile',
                'formAction' => $this->generateUrl('gyg_app_edit_point_apport', array('idTextile' => $textile->getId())),
                'elementToEdit' => $textile,
                'routeToApi' => 'gyg_app_api_textile',
                'user' => $user
            ));
        }
    }

}
