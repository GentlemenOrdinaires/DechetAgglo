<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 06/05/2015
 * Time: 09:59
 */

namespace GYG\AppBundle\Controller;

use GYG\AppBundle\Entity\Localisation;
use GYG\AppBundle\Entity\PointApport;
use GYG\AppBundle\ValueObject\Point;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function testAction()
    {
        $service = $this->get('service_geo_json');

        return new JsonResponse(['test' => 'ok']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPointApportAction(Request $request)
    {
        if ($request->query->get('latitude') && $request->query->get('longitude')) {
            $point = new Point($request->query->get('latitude'), $request->query->get('longitude'));

            $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\PointApport')->findByPoint($point);

            $entitiesArray = [];
            foreach ($entities as $entity) {
                if ($entity instanceof PointApport) {
                    $entitiesArray[] = $this->get('hydrator_point_apport')->extract($entity);
                }
            }
            return new JsonResponse($entitiesArray);
        } elseif ($request->query->get('id')) {
            $result = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\PointApport')->find($request->query->get('id'));
            if ($result instanceof PointApport) {
                return new JsonResponse($this->get('hydrator_point_apport')->extract($result));
            }
        } else {
            $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\PointApport')->findAll();

            $entitiesArray = [];
            foreach ($entities as $entity) {
                if ($entity instanceof PointApport) {
                    $entitiesArray[] = $this->get('hydrator_point_apport')->extract($entity);
                }
            }
            return new JsonResponse($entitiesArray);
        }
    }
}