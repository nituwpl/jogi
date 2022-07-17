<?php

/*
 * This file is part of Prokerala Astrology API PHP SDK
 *
 * © Ennexa Technologies <info@ennexa.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Prokerala\Api\Astrology\Result\Horoscope\Yoga;

final class AdvancedYogaDetails
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var Yoga[]
     */
    private $yogaList;
    /**
     * @param string $name
     * @param string $description
     * @param Yoga[] $yogaList
     */
    public function __construct($name, $description, array $yogaList)
    {
        $this->name = $name;
        $this->description = $description;
        $this->yogaList = $yogaList;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @return Yoga[]
     */
    public function getYogaList()
    {
        return $this->yogaList;
    }
}
