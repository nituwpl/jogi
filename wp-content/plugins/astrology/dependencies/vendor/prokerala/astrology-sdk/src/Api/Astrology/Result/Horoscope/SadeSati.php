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

use Prokerala\Api\Astrology\Result\ResultInterface;
use Prokerala\Api\Astrology\Traits\Result\RawResponseTrait;
final class SadeSati implements \Prokerala\Api\Astrology\Result\ResultInterface
{
    use RawResponseTrait;
    /**
     * @var bool
     */
    private $isInSadeSati;
    /**
     * @var string
     */
    private $transitPhase;
    /**
     * @var null|string
     */
    private $description;
    /**
     * @param bool        $isInSadeSati
     * @param null|string $transitPhase
     * @param string      $description
     */
    public function __construct($isInSadeSati, $transitPhase, $description)
    {
        $this->isInSadeSati = $isInSadeSati;
        $this->transitPhase = $transitPhase;
        $this->description = $description;
    }
    /**
     * @return bool
     */
    public function isInSadeSati()
    {
        return $this->isInSadeSati;
    }
    /**
     * @return null|string
     */
    public function getTransitPhase()
    {
        return $this->transitPhase;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
