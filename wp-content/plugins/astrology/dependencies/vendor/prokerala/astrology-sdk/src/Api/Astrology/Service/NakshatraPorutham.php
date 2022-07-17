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

use Prokerala\Api\Astrology\NakshatraProfile;
use Prokerala\Api\Astrology\Result\HoroscopeMatching\AdvancedNakshatraPorutham as AdvancedPorutham;
use Prokerala\Api\Astrology\Result\HoroscopeMatching\NakshatraPorutham as Porutham;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class NakshatraPorutham
{
    use ClientAwareTrait;
    protected $slug = 'nakshatra-porutham';
    /** @var Transformer<Porutham> */
    private $basicResponseTransformer;
    /** @var Transformer<AdvancedPorutham> */
    private $advancedResponseTransformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->basicResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\HoroscopeMatching\NakshatraPorutham::class);
        $this->advancedResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\HoroscopeMatching\AdvancedNakshatraPorutham::class);
    }
    /**
     * @param bool $detailed_report
     *
     * @return AdvancedPorutham|Porutham
     */
    public function process(\Prokerala\Api\Astrology\NakshatraProfile $girl_profile, \Prokerala\Api\Astrology\NakshatraProfile $boy_profile, $detailed_report = \false)
    {
        $slug = $this->slug;
        if ($detailed_report) {
            $slug .= '/advanced';
        }
        $parameters = ['girl_nakshatra' => $girl_profile->getNakshatra(), 'girl_nakshatra_pada' => $girl_profile->getNakshatraPada(), 'boy_nakshatra' => $boy_profile->getNakshatra(), 'boy_nakshatra_pada' => $boy_profile->getNakshatraPada()];
        $apiResponse = $this->apiClient->process($slug, $parameters);
        if ($detailed_report) {
            return $this->advancedResponseTransformer->transform($apiResponse->data);
        }
        return $this->basicResponseTransformer->transform($apiResponse->data);
    }
}
