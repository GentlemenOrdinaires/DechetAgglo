<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\Textile;
use GYG\AppBundle\Form\TextileType;
use GYG\AppBundle\Entity\Localisation;

class TextileController extends Controller
{
    public function addAction(Request $request)
    {
        $textile = new Textile();
        $form = $this->createForm(new TextileType(), $textile);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $parseFromJsonService = $this->get('service_geo_json');
            $point = $parseFromJsonService->parseToPoint($request->request->get('gyg_appbundle_textile')['geojson']);
            $textile->setLocalisation(new Localisation($point));

            $em = $this->getDoctrine()->getManager();
            $em->persist($textile);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport textile bien enregistré.');

            return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
        }

        return $this->render('GYGAppBundle:Textile:form_textile.html.twig', array(
            'form' => $form->createView(),
            'textile' => $textile
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
        }else{

            $em = $this->getDoctrine()->getManager();
            $textile = $em->getRepository('GYGAppBundle:Textile')->find($idTextile);

            if (!$textile) {
                throw $this->createNotFoundException(
                    'Aucun point d\'apport textile trouvé pour cet id : ' . $idTextile
                );
            }

            $form = $this->createForm(new TextileType(), $textile);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $em->flush();

                return $this->redirect($this->generateUrl('gyg_app_adminpage'));
            }

            return $this->render('GYGAppBundle:Textile:form_textile.html.twig', array(
                'form' => $form->createView(),
                'textile' => $textile
            ));
        }
    }

}
