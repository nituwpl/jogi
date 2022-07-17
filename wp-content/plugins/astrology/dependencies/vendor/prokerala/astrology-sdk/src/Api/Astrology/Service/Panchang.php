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
use Prokerala\Api\Astrology\Result\Panchang\AdvancedPanchang as AdvancedPanchangResult;
use Prokerala\Api\Astrology\Result\Panchang\Panchang as PanchangResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Api\Astrology\Traits\Service\TimeZoneAwareTrait;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class Panchang
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    use TimeZoneAwareTrait;
    /** @var string */
    protected $slug = 'panchang';
    /** @var Transformer<PanchangResult> */
    private $basicResponseTransformer;
    /** @var Transformer<AdvancedPanchangResult */
    private $advancedResponseTransformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->basicResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Panchang\Panchang::class);
        $this->addDateTimeTransformer($this->basicResponseTransformer);
        $this->advancedResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Panchang\AdvancedPanchang::class);
        $this->addDateTimeTransformer($this->advancedResponseTransformer);
    }
    /**
     * Fetch result from API.
     *
     * @param Location           $location        Location details
     * @param \DateTimeInterface $datetime        Date and time
     * @param bool               $detailed_report Return detailed result
     *
     * @throws QuotaExceededException
     * @throws RateLimitExceededException
     *
     * @return AdvancedPanchangResult|PanchangResult
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
