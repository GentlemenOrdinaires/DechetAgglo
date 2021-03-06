<?php
/**
 * Created by Guillaume Prost <hello@guillaumeprost.me>.
 * Date: 02/06/2015
 * Time: 09:22
 */
namespace GYG\AppBundle\Service;


use Doctrine\Common\Collections\ArrayCollection;
use GYG\AppBundle\Entity\Localisation;
use GYG\AppBundle\Entity\Mapable;
use GYG\AppBundle\ValueObject\Point;

class GeoJson
{
    /**
     * @param Mapable $mapable
     * @return array
     */
    public function parsePointToGeoJson(Point $point)
    {

        $arrayGeoJson = [
            'type' => 'FeatureCollection',
            'features' => [[
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $point->getLongitude(),
                        $point->getLatitude()
                    ],
                    'properties' => null
                ]
            ]]
        ];
        return $arrayGeoJson;
    }

    /**
     * @param array $mapableArray
     * @return array|bool
     */
    public function parseArrayToGeoJson($pointArray)
    {
        $coordinatesArray = [];

        foreach ($pointArray as $point) {
            if ($point instanceof Point) {
                $coordinatesArray[] = [
                    $point->getLongitude(),
                    $point->getLatitude()
                ];
            } elseif ($point instanceof Localisation) {
                $coordinatesArray[] = [
                    $point->getPoint()->getLongitude(),
                    $point->getPoint()->getLatitude()
                ];
            }
        }
        if (!isset($coordinatesArray)) {
            return false;
        }

        $arrayGeoJson = [
            'type' => 'FeatureCollection',
            'features' => [[
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [$coordinatesArray],
                    'properties' => null
                ]
            ]]
        ];
        return $arrayGeoJson;
    }

    /**
     *
     * @param string $geoJson
     * @return Point|bool|array $mapable
     */
    public function parseToPoint($geoJson)
    {
        $geoJsonArray = json_decode($geoJson, true);

        if ($geoJsonArray === false) {
            return false;
        }
        if (isset($geoJsonArray['features'][0]['geometry']['type']) && $geoJsonArray['features'][0]['geometry']['type'] == 'Point') {
            return new Point($geoJsonArray['features'][0]['geometry']['coordinates'][1], $geoJsonArray['features'][0]['geometry']['coordinates'][0]);
        } elseif (isset($geoJsonArray['features'][0]['geometry']['type']) && $geoJsonArray['features'][0]['geometry']['type'] == 'Polygon') {
            $pointArray = new ArrayCollection();
            foreach ($geoJsonArray['features'][0]['geometry']['coordinates'][0] as $coordinates) {
                $pointArray[] = new Localisation(new Point($coordinates[1], $coordinates[0]));
            }
            return $pointArray;
        } else {
            return false;
        }
    }
}