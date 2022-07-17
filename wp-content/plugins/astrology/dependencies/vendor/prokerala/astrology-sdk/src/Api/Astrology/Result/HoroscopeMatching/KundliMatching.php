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

use Prokerala\Api\Astrology\Result\HoroscopeMatching\GunaMilan\GunaMilan;
use Prokerala\Api\Astrology\Result\ResultInterface;
use Prokerala\Api\Astrology\Traits\Result\RawResponseTrait;
final class KundliMatching implements \Prokerala\Api\Astrology\Result\ResultInterface
{
    use RawResponseTrait;
    /** @var ProfileInfo */
    private $girlInfo;
    /** @var ProfileInfo */
    private $boyInfo;
    /**
     * @var Message
     */
    private $message;
    /**
     * @var GunaMilan
     */
    private $gunaMilan;
    public function __construct(\Prokerala\Api\Astrology\Result\HoroscopeMatching\ProfileInfo $girlInfo, \Prokerala\Api\Astrology\Result\HoroscopeMatching\ProfileInfo $boyInfo, \Prokerala\Api\Astrology\Result\HoroscopeMatching\Message $message, \Prokerala\Api\Astrology\Result\HoroscopeMatching\GunaMilan\GunaMilan $gunaMilan)
    {
        $this->girlInfo = $girlInfo;
        $this->boyInfo = $boyInfo;
        $this->message = $message;
        $this->gunaMilan = $gunaMilan;
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
     * @return GunaMilan
     */
    public function getGunaMilan()
    {
        return $this->gunaMilan;
    }
}
