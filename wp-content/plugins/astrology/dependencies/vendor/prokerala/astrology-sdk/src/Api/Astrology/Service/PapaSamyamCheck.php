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

use Prokerala\Api\Astrology\Profile;
use Prokerala\Api\Astrology\Result\HoroscopeMatching\PapaSamyamCheck as PapaSamyamCheckResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class PapaSamyamCheck
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    protected $slug = 'papasamyam-check';
    /** @var Transformer<PapaSamyamCheckResult> */
    private $transformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->transformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\HoroscopeMatching\PapaSamyamCheck::class);
    }
    /**
     * Fetch result from API.
     *
     * @return PapaSamyamCheckResult
     */
    public function process(\Prokerala\Api\Astrology\Profile $girl_profile, \Prokerala\Api\Astrology\Profile $boy_profile)
    {
        $girl_location = $girl_profile->getLocation();
        $boy_location = $boy_profile->getLocation();
        $parameters = ['girl_coordinates' => $girl_location->getCoordinates(), 'girl_dob' => $girl_profile->getDateTime()->format('c'), 'boy_coordinates' => $boy_location->getCoordinates(), 'boy_dob' => $boy_profile->getDateTime()->format('c'), 'ayanamsa' => $this->getAyanamsa()];
        $apiResponse = $this->apiClient->process($this->slug, $parameters);
        return $this->transformer->transform($apiResponse->data);
    }
}
