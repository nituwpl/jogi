<?php

/*
 * This file is part of Prokerala Astrology API PHP SDK
 *
 * © Ennexa Technologies <info@ennexa.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Prokerala\Api\Astrology\Service;

use DateTimeInterface;
use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Result\Horoscope\PlanetPosition as PlanetPositionResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class PlanetPosition
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    protected $slug = 'planet-position';
    /** @var Transformer<PlanetPositionResult> */
    private $transformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->transformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Horoscope\PlanetPosition::class);
    }
    /**
     * Fetch result from API.
     *
     * @param Location          $location Location details
     * @param DateTimeInterface $datetime Date and time
     * @param null|string       $planets
     *
     * @return PlanetPositionResult
     */
    public function process(\Prokerala\Api\Astrology\Location $location, \DateTimeInterface $datetime, $planets = null)
    {
        $parameters = ['datetime' => $datetime->format('c'), 'coordinates' => $location->getCoordinates(), 'ayanamsa' => $this->getAyanamsa(), 'planets' => $planets];
        $apiResponse = $this->apiClient->process($this->slug, $parameters);
        return $this->transformer->transform($apiResponse->data);
    }
}
