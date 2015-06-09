<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 01/06/2015
 * Time: 14:20
 */

namespace GYG\AppBundle\Hydrator;


use GYG\AppBundle\Entity\Dechet;
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
        $array = [
            'id' => $pointApport->getId(),
            'infos' => $pointApport->getInfos(),
            'photo' => $pointApport->getPhoto()
        ];
        if ($pointApport instanceof PointApport\Aerien) {
            $array['type'] = PointApport\Aerien::DISCRIMINATOR;
            if (!$pointApport->getDechets()->isEmpty()) {
                foreach ($pointApport->getDechets() as $dechet) {
                    if ($dechet instanceof Dechet) {
                        $array['dechets'][] = [
                            'id' => $dechet->getId(),
                            'libelle' => $dechet->getLibelle(),
                            'type' => $dechet::DISCRIMINATOR
                        ];
                    }
                }
            }
        } elseif ($pointApport instanceof PointApport\Enterre) {
            $array['type'] = PointApport\Enterre::DISCRIMINATOR;
            if (!$pointApport->getDechets()->isEmpty()) {
                foreach ($pointApport->getDechets() as $dechet) {
                    if ($dechet instanceof Dechet) {
                        $array['dechets'][] = [
                            'id' => $dechet->getId(),
                            'libelle' => $dechet->getLibelle(),
                            'type' => $dechet::DISCRIMINATOR
                        ];
                    }
                }
            }
        }
        $array['geoJson'] = $pointApport->getLocalisation() instanceof Localisation ? $this->geoJsonService->parsePointToGeoJson($pointApport->getLocalisation()->getPoint()) : null;

        return $array;
    }
}