<?php

namespace Prokerala\Astrology\Vendor\Http\Client;

use Psr\Http\Client\ClientInterface;
/**
 * {@inheritdoc}
 *
 * Provide the Httplug HttpClient interface for BC.
 * You should typehint Psr\Http\Client\ClientInterface in new code
 */
interface HttpClient extends \Psr\Http\Client\ClientInterface
{
}
