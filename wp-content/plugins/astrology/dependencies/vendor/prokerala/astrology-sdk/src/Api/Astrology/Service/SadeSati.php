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

use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Result\Horoscope\AdvancedSadeSati as AdvancedSadeSatiResult;
use Prokerala\Api\Astrology\Result\Horoscope\SadeSati as SadeSatiResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Api\Astrology\Traits\Service\TimeZoneAwareTrait;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class SadeSati
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    use TimeZoneAwareTrait;
    /** @var string */
    protected $slug = 'sade-sati';
    /** @var Transformer<AdvancedSadeSatiResult> */
    private $advancedResponseTransformer;
    /** @var Transformer<SadeSatiResult> */
    private $basicResponseTransformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->basicResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Horoscope\SadeSati::class);
        $this->advancedResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Horoscope\AdvancedSadeSati::class);
        $this->addDateTimeTransformer($this->advancedResponseTransformer);
    }
    /**
     * Fetch result from API.
     *
     * @param Location           $location        Location details
     * @param \DateTimeInterface $datetime        Date and time
     * @param bool               $detailed_report
     *
     * @return AdvancedSadeSatiResult|SadeSatiResult
     */
    public function process(\Prokerala\Api\Astrology\Location $location, \DateTimeInterface $datetime, $detailed_report = \false)
    {
        $slug = $this->slug;
        if ($detailed_report) {
            $slug .= '/advanced';
        }
        $parameters = ['datetime' => $datetime->format('c'), 'coordinates' => $location->getCoordinates(), 'ayanamsa' => $this->getAyanamsa()];
        $apiResponse = $this->apiClient->process($slug, $parameters);
        if ($detailed_report) {
            return $this->advancedResponseTransformer->transform($apiResponse->data);
        }
        return $this->basicResponseTransformer->transform($apiResponse->data);
    }
}
