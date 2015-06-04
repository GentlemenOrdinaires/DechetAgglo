<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 04/06/2015
 * Time: 11:34
 */

namespace GYG\AppBundle\Hydrator;


use GYG\AppBundle\Entity\DechetSoin;
use Proxies\__CG__\GYG\AppBundle\Entity\Localisation;

class DechetSoinHydrator {

    /**
     * @var GeoJson
     */
    private $geoJsonService;

    public function __construct(GeoJson $geoJsonService)
    {
        $this->geoJsonService = $geoJsonService;
    }

    /**
     * @param DechetSoin $dechetSoin
     */
    public function extract(DechetSoin $dechetSoin){
        $array = [
            'id' => $dechetSoin->getId(),
            'infos' => $dechetSoin->getInfos() ? $dechetSoin->getInfos() : null,
        ];
        $array['geoJson'] = $dechetSoin->getLocalisation() instanceof Localisation ? $this->geoJsonService->parsePointToGeoJson($dechetSoin->getLocalisation()->getPoint()) : null;

        return $array;
    }

}