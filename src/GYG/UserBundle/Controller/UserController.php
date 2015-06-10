<?php
/**
 * Created by PhpStorm.
 * User: yassir
 * Date: 04/06/2015
 * Time: 15:12
 */

namespace GYG\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller{

    public function deleteAction($idUser, Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GYGUserBundle:User')->find($idUser);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $em->remove($user);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien supprimé.');

        return $this->redirect($this->generateUrl('gyg_app_adminpage', array()));
    }

    public function listAction(){
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->getUser();
        $this->users = $userManager->findUsers();

        return $this->render('GYGUserBundle:User:list.html.twig',array(
            'user' => $user,
            'users'     => $this->users,
        ));
    }

}