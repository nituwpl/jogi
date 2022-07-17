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
use Prokerala\Api\Astrology\Result\Horoscope\AdvancedMangalDosha as AdvancedMangalDoshaResult;
use Prokerala\Api\Astrology\Result\Horoscope\MangalDosha as MangalDoshaResult;
use Prokerala\Api\Astrology\Traits\Service\AyanamsaAwareTrait;
use Prokerala\Api\Astrology\Transformer;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Traits\Api\ClientAwareTrait;
final class MangalDosha
{
    use AyanamsaAwareTrait;
    use ClientAwareTrait;
    protected $slug = 'mangal-dosha';
    /** @var Transformer<MangalDoshaResult> */
    private $basicResponseTransformers;
    /** @var Transformer<AdvancedMangalDoshaResult> */
    private $advancedResponseTransformer;
    /**
     * @param Client $client Api client
     */
    public function __construct(\Prokerala\Common\Api\Client $client)
    {
        $this->apiClient = $client;
        $this->basicResponseTransformers = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Horoscope\MangalDosha::class);
        $this->advancedResponseTransformer = new \Prokerala\Api\Astrology\Transformer(\Prokerala\Api\Astrology\Result\Horoscope\AdvancedMangalDosha::class);
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
     * @return AdvancedMangalDoshaResult|MangalDoshaResult
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
        return $this->basicResponseTransformers->transform($apiResponse->data);
    }
}
