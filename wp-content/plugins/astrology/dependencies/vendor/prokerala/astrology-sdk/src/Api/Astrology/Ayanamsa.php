<?php

/*
 * This file is part of Prokerala Astrology API PHP SDK
 *
 * © Ennexa Technologies <info@ennexa.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Prokerala\Api\Astrology;

final class Ayanamsa
{
    const LAHIRI = 1;
    const RAMAN = 3;
    const KP = 5;
    /**
     * Get list of supported ayanamsas.
     *
     * @return array<int,string>
     */
    public function getAyanamsaList()
    {
        return [self::LAHIRI => 'Lahiri', self::RAMAN => 'Raman', self::KP => 'KP'];
    }
}
