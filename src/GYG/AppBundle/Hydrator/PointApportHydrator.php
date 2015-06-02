<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 01/06/2015
 * Time: 14:20
 */

namespace GYG\AppBundle\Hydrator;


use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use GYG\AppBundle\Entity\Localisation;
use GYG\AppBundle\Entity\PointApport;
use GYG\AppBundle\Service\GeoJson;

class PointApportHydrator
{

    /**
     * @var GeoJson
     */
    private $geoJsonService;

    public function __construct(GeoJson $geoJsonService)
    {
        $this->geoJsonService = $geoJsonService;
    }

    /**
     * @param PointApport $pointApport
     */
    public function extract(PointApport $pointApport)
    {
        $array = [];
        $array ['infos'] = $pointApport->getInfos();
        $array['geoJson'] = $pointApport->getLocalisation() instanceof Localisation ? $this->geoJsonService->parsePointToGeoJson($pointApport->getLocalisation()->getPoint()) : null;

        return $array;
    }
}