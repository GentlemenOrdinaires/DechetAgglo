<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 04/06/2015
 * Time: 15:17
 */

namespace GYG\AppBundle\Hydrator;


use GYG\AppBundle\Entity\Localisation;
use GYG\AppBundle\Service\GeoJson;
use GYG\AppBundle\Entity\Textile;

class TextileHydrator
{

    /**
     * @var GeoJson
     */
    private $geoJsonService;

    /**
     * @param GeoJson $geoJsonService
     */
    public function __construct(GeoJson $geoJsonService)
    {
        $this->geoJsonService = $geoJsonService;
    }

    /**
     * @param Decheterie $decheterie
     * @return array
     */
    public function extract(Textile $textile)
    {
        $array = [
            'id' => $textile->getId(),
            'infos' => $textile->getInfos() ? $textile->getInfos() : null,
        ];
        $array['geoJson'] = $textile->getLocalisation() instanceof Localisation ? $this->geoJsonService->parsePointToGeoJson($textile->getLocalisation()->getPoint()) : null;

        return $array;
    }
}