<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\Trajet;
use GYG\AppBundle\Form\TrajetType;

class TrajetController extends Controller
{
    public function addAction(Request $request)
    {
        $trajet = new Trajet();
        $form = $this->createForm(new TrajetType(), $trajet);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $parseFromJsonService = $this->get('service_geo_json');
            $localisations = $parseFromJsonService->parseToPoint($request->request->get('gyg_appbundle_trajet')['geojson']);
            $trajet->setLocalisations($localisations);

            $em = $this->getDoctrine()->getManager();
            $em->persist($trajet);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Trajet bien enregistré.');

            return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
        }

        return $this->render('GYGAppBundle:Trajet:form_trajet.html.twig', array(
            'form' => $form->createView(),
            'trajet' => $trajet
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
        }else{

            $em = $this->getDoctrine()->getManager();
            $trajet = $em->getRepository('GYGAppBundle:Trajet')->find($idTrajet);

            if (!$trajet) {
                throw $this->createNotFoundException(
                    'Aucun trajet trouvé pour cet id : ' . $idTrajet
                );
            }

            $form = $this->createForm(new TrajetType(), $trajet);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $em->flush();

                return $this->redirect($this->generateUrl('gyg_app_adminpage'));
            }

            return $this->render('GYGAppBundle:Trajet:form_trajet.html.twig', array(
                'form' => $form->createView(),
                'trajet' => $trajet
            ));
        }
    }

}
