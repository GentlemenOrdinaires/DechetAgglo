<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\Decheterie;
use GYG\AppBundle\Form\DecheterieType;

class DecheterieController extends Controller
{
    public function addAction(Request $request)
    {
        $decheterie = new Decheterie();
        $form = $this->createForm(new DecheterieType(), $decheterie);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($decheterie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Décheterie bien enregistrée.');

            return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
        }

        return $this->render('GYGAppBundle:Decheterie:form_decheterie.html.twig', array(
            'form' => $form->createView(),
            'decheterie' => $decheterie
        ));
    }

    public function deleteAction($idDecheterie, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $decheterie = $em->getRepository('GYGAppBundle:Decheterie')->find($idDecheterie);

        if (!$decheterie) {
            throw $this->createNotFoundException('Décheterie non trouvée');
        }

        $em->remove($decheterie);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Décheterie bien supprimée.');

        return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
    }

    public function listAction(){
        $em = $this->getDoctrine()->getManager();
        $decheteries = $em->getRepository('GYGAppBundle:Decheterie')->findAll();

        if (!$decheteries) {
            throw $this->createNotFoundException('Aucune décheterie trouvée');
        }

        return $this->render('GYGAppBundle:Decheterie:list_decheterie.html.twig', array(
            'decheteries' => $decheteries
        ));
    }

    public function editAction($idDecheterie, Request $request)
    {
        if($idDecheterie == 0){
           return $this->addAction($request);
        }else{

            $em = $this->getDoctrine()->getManager();
            $decheterie = $em->getRepository('GYGAppBundle:Decheterie')->find($idDecheterie);

            if (!$decheterie) {
                throw $this->createNotFoundException(
                    'Aucune décheterie trouvée pour cet id : ' . $idDecheterie
                );
            }

            $form = $this->createForm(new DecheterieType(), $decheterie);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $em->flush();

                return $this->redirect($this->generateUrl('gyg_app_adminpage'));
            }

            return $this->render('GYGAppBundle:Decheterie:form_decheterie.html.twig', array(
                'form' => $form->createView(),
                'decheterie' => $decheterie
            ));
        }
    }

}
