<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 04/06/2015
 * Time: 14:01
 */

namespace GYG\AppBundle\Hydrator;


use GYG\AppBundle\Entity\Decheterie;
use GYG\AppBundle\Entity\Localisation;
use GYG\AppBundle\Service\GeoJson;

class DecheterieHydrator
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
    public function extract(Decheterie $decheterie)
    {
        $array = [
            'id' => $decheterie->getId(),
            'infos' => $decheterie->getInfos(),
            'horaires' => $decheterie->getHoraires(),
            'photo' => $decheterie->getPhoto()
        ];
        $array['geoJson'] = $decheterie->getLocalisation() instanceof Localisation ? $this->geoJsonService->parsePointToGeoJson($decheterie->getLocalisation()->getPoint()) : null;

        return $array;
    }
}