<?php

/*
 * This file is part of Prokerala Astrology API PHP SDK
 *
 * © Ennexa Technologies <info@ennexa.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Prokerala\Api\Astrology\Result\Horoscope;

use Prokerala\Api\Astrology\Result\Element\Nakshatra;
use Prokerala\Api\Astrology\Result\Element\Rasi;
use Prokerala\Api\Astrology\Result\Element\Zodiac;
use Prokerala\Api\Astrology\Result\Horoscope\Nakshatra\NakshatraInfo;
use Prokerala\Api\Astrology\Result\ResultInterface;
use Prokerala\Api\Astrology\Traits\Result\RawResponseTrait;
final class BirthDetails implements \Prokerala\Api\Astrology\Result\ResultInterface
{
    use RawResponseTrait;
    /**
     * @var \Prokerala\Api\Astrology\Result\Element\Nakshatra
     */
    private $nakshatra;
    /**
     * @var \Prokerala\Api\Astrology\Result\Element\Rasi
     */
    private $chandraRasi;
    /**
     * @var \Prokerala\Api\Astrology\Result\Element\Rasi
     */
    private $sooryaRasi;
    /**
     * @var \Prokerala\Api\Astrology\Result\Element\Zodiac
     */
    private $zodiac;
    /**
     * @var Nakshatra\NakshatraInfo
     */
    private $additionalInfo;
    /**
     * BirthDetails constructor.
     *
     * @param Nakshatra\NakshatraInfo $additionalInfo
     */
    public function __construct(\Prokerala\Api\Astrology\Result\Element\Nakshatra $nakshatra, \Prokerala\Api\Astrology\Result\Element\Rasi $chandraRasi, \Prokerala\Api\Astrology\Result\Element\Rasi $sooryaRasi, \Prokerala\Api\Astrology\Result\Element\Zodiac $zodiac, \Prokerala\Api\Astrology\Result\Horoscope\Nakshatra\NakshatraInfo $additionalInfo)
    {
        $this->nakshatra = $nakshatra;
        $this->chandraRasi = $chandraRasi;
        $this->sooryaRasi = $sooryaRasi;
        $this->zodiac = $zodiac;
        $this->additionalInfo = $additionalInfo;
    }
    /**
     * @return \Prokerala\Api\Astrology\Result\Element\Nakshatra
     */
    public function getNakshatra()
    {
        return $this->nakshatra;
    }
    /**
     * @return \Prokerala\Api\Astrology\Result\Element\Rasi
     */
    public function getChandraRasi()
    {
        return $this->chandraRasi;
    }
    /**
     * @return \Prokerala\Api\Astrology\Result\Element\Rasi
     */
    public function getSooryaRasi()
    {
        return $this->sooryaRasi;
    }
    /**
     * @return \Prokerala\Api\Astrology\Result\Element\Zodiac
     */
    public function getZodiac()
    {
        return $this->zodiac;
    }
    /**
     * @return Nakshatra\NakshatraInfo
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }
}
