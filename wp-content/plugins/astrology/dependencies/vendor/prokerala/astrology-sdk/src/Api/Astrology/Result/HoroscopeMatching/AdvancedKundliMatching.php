<?php

/*
 * This file is part of Prokerala Astrology API PHP SDK
 *
 * © Ennexa Technologies <info@ennexa.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Prokerala\Api\Astrology\Result\HoroscopeMatching;

use Prokerala\Api\Astrology\Result\HoroscopeMatching\GunaMilan\AdvancedGunaMilan;
use Prokerala\Api\Astrology\Result\ResultInterface;
use Prokerala\Api\Astrology\Traits\Result\RawResponseTrait;
final class AdvancedKundliMatching implements \Prokerala\Api\Astrology\Result\ResultInterface
{
    use RawResponseTrait;
    /** @var ProfileInfo */
    private $girlInfo;
    /** @var ProfileInfo */
    private $boyInfo;
    /** @var Message */
    private $message;
    /** @var AdvancedGunaMilan */
    private $gunaMilan;
    /** @var MangalDosha */
    private $girlMangalDoshaDetails;
    /** @var MangalDosha */
    private $boyMangalDoshaDetails;
    /** @var string[] */
    private $exceptions;
    /**
     * AdvancedKundliMatching constructor.
     *
     * @param string[] $exceptions
     */
    public function __construct(\Prokerala\Api\Astrology\Result\HoroscopeMatching\ProfileInfo $girlInfo, \Prokerala\Api\Astrology\Result\HoroscopeMatching\ProfileInfo $boyInfo, \Prokerala\Api\Astrology\Result\HoroscopeMatching\Message $message, \Prokerala\Api\Astrology\Result\HoroscopeMatching\GunaMilan\AdvancedGunaMilan $gunaMilan, \Prokerala\Api\Astrology\Result\HoroscopeMatching\MangalDosha $girlMangalDoshaDetails, \Prokerala\Api\Astrology\Result\HoroscopeMatching\MangalDosha $boyMangalDoshaDetails, array $exceptions)
    {
        $this->girlInfo = $girlInfo;
        $this->boyInfo = $boyInfo;
        $this->message = $message;
        $this->gunaMilan = $gunaMilan;
        $this->girlMangalDoshaDetails = $girlMangalDoshaDetails;
        $this->boyMangalDoshaDetails = $boyMangalDoshaDetails;
        $this->exceptions = $exceptions;
    }
    /**
     * @return ProfileInfo
     */
    public function getGirlInfo()
    {
        return $this->girlInfo;
    }
    /**
     * @return ProfileInfo
     */
    public function getBoyInfo()
    {
        return $this->boyInfo;
    }
    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * @return AdvancedGunaMilan
     */
    public function getGunaMilan()
    {
        return $this->gunaMilan;
    }
    /**
     * @return MangalDosha
     */
    public function getGirlMangalDoshaDetails()
    {
        return $this->girlMangalDoshaDetails;
    }
    /**
     * @return MangalDosha
     */
    public function getBoyMangalDoshaDetails()
    {
        return $this->boyMangalDoshaDetails;
    }
    /**
     * @return string[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
}
