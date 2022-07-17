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
use Prokerala\Api\Astrology\Result\Horoscope\Chart as ChartResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class Chart
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    /** @var string */
    protected $slug = 'chart';
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
    }
    /**
     * Fetch result from API.
     *
     * @param Location           $location    Location details
     * @param \DateTimeInterface $datetime    Date and time
     * @param string             $chart_type  Chart type
     * @param string             $chart_style
     *
     * @return ChartResult
     */
    public function process(\Prokerala\Api\Astrology\Location $location, $datetime, $chart_type, $chart_style)
    {
        $parameters = ['datetime' => $datetime->format('c'), 'coordinates' => $location->getCoordinates(), 'ayanamsa' => $this->getAyanamsa(), 'chart_type' => $chart_type, 'chart_style' => $chart_style];
        return $this->apiClient->process($this->slug, $parameters);
    }
}
