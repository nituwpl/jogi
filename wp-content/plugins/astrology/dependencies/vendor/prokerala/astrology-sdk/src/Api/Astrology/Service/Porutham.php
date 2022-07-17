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
use Prokerala\Api\Astrology\Result\HoroscopeMatching\AdvancedPorutham as AdvancedMatchResult;
use Prokerala\Api\Astrology\Result\HoroscopeMatching\Porutham as MatchResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class Porutham
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    protected $slug = 'porutham';
    /** @var Transformer<MatchResult> */
    private $basicResponseTransformer;
    /** @var Transformer<AdvancedMatchResult> */
    private $advancedResponseTransformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->basicResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\HoroscopeMatching\Porutham::class);
        $this->advancedResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\HoroscopeMatching\AdvancedPorutham::class);
    }
    /**
     * Fetch result from API.
     *
     * @param $system
     * @param bool $detailed_report
     *
     * @return AdvancedMatchResult|MatchResult
     */
    public function process(\Prokerala\Api\Astrology\Profile $girl_profile, \Prokerala\Api\Astrology\Profile $boy_profile, $system, $detailed_report = \false)
    {
        $slug = $this->slug;
        if ($detailed_report) {
            $slug .= '/advanced';
        }
        $girl_location = $girl_profile->getLocation();
        $boy_location = $boy_profile->getLocation();
        $parameters = ['girl_coordinates' => $girl_location->getCoordinates(), 'girl_dob' => $girl_profile->getDateTime()->format('c'), 'boy_coordinates' => $boy_location->getCoordinates(), 'boy_dob' => $boy_profile->getDateTime()->format('c'), 'system' => $system, 'ayanamsa' => $this->getAyanamsa()];
        $apiResponse = $this->apiClient->process($slug, $parameters);
        if ($detailed_report) {
            return $this->advancedResponseTransformer->transform($apiResponse->data);
        }
        return $this->basicResponseTransformer->transform($apiResponse->data);
    }
}
