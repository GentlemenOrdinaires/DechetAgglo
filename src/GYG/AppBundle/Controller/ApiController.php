<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 06/05/2015
 * Time: 09:59
 */

namespace GYG\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function testAction()
    {
        $data = ['test' => 'ok'];
        return new JsonResponse($data);
    }

    public function getPointApportByLocation(Request $request){

        if($request->query->get('latitude') && $request->query->get('longitude')){

        }
    }
}