<?php

namespace GYG\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GYG\AppBundle\Entity\DechetSoin;
use GYG\AppBundle\Form\DechetSoinType;
use GYG\AppBundle\Entity\Localisation;

class DechetSoinController extends Controller
{
    public function addAction(Request $request)
    {
        $dechetSoin = new DechetSoin();
        $form = $this->createForm(new DechetSoinType(), $dechetSoin);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $parseFromJsonService = $this->get('service_geo_json');
            $point = $parseFromJsonService->parseToPoint($request->request->get('gyg_appbundle_dechetsoin')['geojson']);
            $dechetSoin->setLocalisation(new Localisation($point));

            $em = $this->getDoctrine()->getManager();
            $em->persist($dechetSoin);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Point d\'apport de déchets de soins bien enregistré.');

            return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
        }

        return $this->render('GYGAppBundle:_partials:form.html.twig', array(
            'form' => $form->createView(),
            'formTitle' => 'AJOUTER UN POINT D\'APPORT DE DECHETS DE SOIN',
            'formAction' => $this->generateUrl('gyg_app_edit_dechet_soin', array()),
            'dechet_soin' => $dechetSoin
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
        }else{

            $em = $this->getDoctrine()->getManager();
            $dechetSoin = $em->getRepository('GYGAppBundle:DechetSoin')->find($idDechetSoin);

            if (!$dechetSoin) {
                throw $this->createNotFoundException(
                    'Aucun point d\'apport de déchets de soins trouvé pour cet id : ' . $idDechetSoin
                );
            }

            $form = $this->createForm(new DechetSoinType(), $dechetSoin);
            //$form->get('filePhoto')->setData($dechetSoin->getPhoto());


            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $em->flush();

                return $this->redirect($this->generateUrl('gyg_app_adminpage'));
            }

            return $this->render('GYGAppBundle:_partials:form.html.twig', array(
                'form' => $form->createView(),
                'formTitle' => 'EDITER UN POINT D\'APPORT DE DECHETS DE SOIN',
                'formAction' => $this->generateUrl('gyg_app_edit_dechet_soin', array( 'idDechetSoin' => $dechetSoin->getId())),
                'dechet_soin' => $dechetSoin
            ));
        }
    }

}
