<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 06/05/2015
 * Time: 09:59
 */

namespace GYG\AppBundle\Controller;

use GYG\AppBundle\Entity\PointApport;
use GYG\AppBundle\Entity\Trajet;
use GYG\AppBundle\ValueObject\Point;
use Proxies\__CG__\GYG\AppBundle\Entity\PointApport\Aerien;
use Proxies\__CG__\GYG\AppBundle\Entity\PointApport\Enterre;
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
        } elseif ($request->query->get('dechetType')) {
            $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\PointApport')->findByDechetType($request->query->get('dechetType'));
            $entitiesArray = [];
            foreach ($entities as $entity) {
                if ($entity instanceof PointApport) {
                    $entitiesArray[] = $this->get('hydrator_point_apport')->extract($entity);
                }
            }
            return new JsonResponse($entitiesArray);
        } elseif ($request->query->get('type')) {
            if ($request->query->get('type') == Aerien::DISCRIMINATOR) {
                $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\PointApport\Aerien')->findAll();
            } elseif ($request->query->get('type') == Enterre::DISCRIMINATOR) {
                $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\PointApport\Enterre')->findAll();
            } else {
                return false;
            }
            $entitiesArray = [];
            foreach ($entities as $entity) {
                if ($entity instanceof PointApport) {
                    $entitiesArray[] = $this->get('hydrator_point_apport')->extract($entity);
                }
            }
            return new JsonResponse($entitiesArray);
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDechetSoin(Request $request){

        $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\DechetSoin')->findAll();

        $entitiesArray = [];
        foreach ($entities as $entity) {
            if ($entity instanceof PointApport) {
                $entitiesArray[] = $this->get('hydrator_dechet_soin')->extract($entity);
            }
        }
        return new JsonResponse($entitiesArray);
    }

    /**
     * @param Request $request
     */
    public function getTrajetAction(Request $request)
    {
        if ($request->query->get('latitude') && $request->query->get('longitude')) {
            $point = new Point($request->query->get('latitude'), $request->query->get('longitude'));

            $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\Trajet')->findByPoint($point);

            $entitiesArray = [];
            foreach ($entities as $entity) {
                if ($entity instanceof Trajet) {
                    $entitiesArray[] = $this->get('hydrator_trajet')->extract($entity);
                }
            }
            return new JsonResponse($entitiesArray);
        } elseif ($request->query->get('id')) {
            $result = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\Trajet')->find($request->query->get('id'));
            if ($result instanceof Trajet) {
                return new JsonResponse($this->get('hydrator_trajet')->extract($result));
            }
        } else {
            $entities = $this->getDoctrine()->getManager()->getRepository('GYG\AppBundle\Entity\Trajet')->findAll();

            $entitiesArray = [];
            foreach ($entities as $entity) {
                if ($entity instanceof Trajet) {
                    $entitiesArray[] = $this->get('hydrator_trajet')->extract($entity);
                }
            }
            return new JsonResponse($entitiesArray);
        }
    }
}

