<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 01/06/2015
 * Time: 15:50
 */

namespace GYG\AppBundle\Hydrator;


use GYG\AppBundle\Entity\Trajet;
use GYG\AppBundle\Service\GeoJson;

class TrajetHydrator
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
     * @param Trajet $trajet
     * @return array
     */
    public function extract(Trajet $trajet)
    {
        $array = [
            'couleur' => $trajet->getCouleur() ? $trajet->getCouleur() : null,
            'jourCollecte' => $trajet->getJourCollecte() ? $trajet->getJourCollecte() : null,
            'jourCollecteSelective' => $trajet->getJourCollecteSelective() ? $trajet->getJourCollecteSelective() : null

        ];
        foreach ($trajet->getLocalisations() as $localisation) {
            $array['geoJson'][] = $this->geoJsonService->parseArrayToGeoJson($localisation);
        }

        return $array;
    }
}