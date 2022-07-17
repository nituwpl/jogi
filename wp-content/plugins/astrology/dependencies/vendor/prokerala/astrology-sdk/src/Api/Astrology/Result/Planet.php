<?php

/*
 * This file is part of Prokerala Astrology API PHP SDK
 *
 * © Ennexa Technologies <info@ennexa.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Prokerala\Api\Astrology\Result;

final class Planet
{
    const SUN = 0;
    const MOON = 1;
    const MERCURY = 2;
    const VENUS = 3;
    const MARS = 4;
    const JUPITER = 5;
    const SATURN = 6;
    const RAHU = 101;
    const KETU = 102;
    const ASCENDANT = 100;
    const PLANET_LIST = [0 => 'Sun', 1 => 'Moon', 2 => 'Mercury', 3 => 'Venus', 4 => 'Mars', 5 => 'Jupiter', 6 => 'Saturn', 101 => 'Rahu', 102 => 'Ketu', 100 => 'Ascendant'];
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var float */
    private $longitude;
    /** @var bool */
    private $isReverse;
    /** @var int */
    private $position;
    /** @var string */
    private $degree;
    /** @var int */
    private $rasi;
    /** @var string */
    private $rasiLord;
    public function __construct($id, $name, $longitude, $is_reverse, $position, $degree, $rasi, $rasi_lord)
    {
        $this->id = $id;
        $this->name = $name;
        $this->longitude = $longitude;
        $this->isReverse = $is_reverse;
        $this->position = $position;
        $this->degree = $degree;
        $this->rasi = $rasi;
        $this->rasiLord = $rasi_lord;
    }
    /**
     * Get planet name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Get planet id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Get planet longitude.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    /**
     * Check whether the planet is in retrograde motion.
     *
     * @return bool
     */
    public function isRetrograde()
    {
        return $this->isReverse;
    }
    /**
     * Get planet position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Get longitude degree.
     *
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }
    /**
     * Get planet rasi.
     *
     * @return string
     */
    public function getRasi()
    {
        return $this->rasi;
    }
    /**
     * Get complete planet list.
     *
     * @return string[]
     */
    public function getPlanetList()
    {
        return self::PLANET_LIST;
    }
}
