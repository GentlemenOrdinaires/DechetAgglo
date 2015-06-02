<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 01/06/2015
 * Time: 15:50
 */

namespace GYG\AppBundle\Hydrator;


use GYG\AppBundle\Entity\Trajet;

class TrajetHydrator
{

    /**
     * @param Trajet $trajet
     * @return array
     */
    public function extract(Trajet $trajet)
    {

        $array = [
            'couleur' => $trajet->getCouleur(),
            'jourCollecte' => $trajet->getJourCollecte(),
            'jourCollecteSelective' => $trajet->getJourCollecteSelective()

        ];
        foreach ($trajet->getLocalisations() as $localisation) {
            $array['localisations'][$localisation->getPoint()->getLatitude()] = $localisation->getPoint()->getLongitude();
        }

        return $array;
    }
}