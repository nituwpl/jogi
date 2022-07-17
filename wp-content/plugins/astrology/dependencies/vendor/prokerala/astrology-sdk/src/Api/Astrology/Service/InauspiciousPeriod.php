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
use Prokerala\Api\Astrology\Result\Panchang\InauspiciousPeriod as InauspiciousPeriodResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Api\Astrology\Traits\Service\TimeZoneAwareTrait;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class InauspiciousPeriod
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    use TimeZoneAwareTrait;
    /** @var string */
    protected $slug = 'inauspicious-period';
    /** @var Transformer<InauspiciousPeriodResult> */
    private $transformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->transformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Panchang\InauspiciousPeriod::class);
        $this->addDateTimeTransformer($this->transformer);
    }
    /**
     * Fetch result from API.
     *
     * @param Location           $location Location details
     * @param \DateTimeInterface $datetime Date and time
     *
     * @return InauspiciousPeriodResult
     */
    public function process(\Prokerala\Api\Astrology\Location $location, \DateTimeInterface $datetime)
    {
        $parameters = ['datetime' => $datetime->format('c'), 'coordinates' => $location->getCoordinates(), 'ayanamsa' => $this->getAyanamsa()];
        $apiResponse = $this->apiClient->process($this->slug, $parameters);
        return $this->transformer->transform($apiResponse->data);
    }
}
