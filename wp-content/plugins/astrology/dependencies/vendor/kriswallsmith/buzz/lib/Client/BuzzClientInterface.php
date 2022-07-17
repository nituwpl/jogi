<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Client;

use Prokerala\Astrology\Vendor\Http\Client\HttpClient;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
interface BuzzClientInterface extends \Psr\Http\Client\ClientInterface, \Prokerala\Astrology\Vendor\Http\Client\HttpClient
{
    /**
     * {@inheritdoc}
     */
    public function sendRequest(\Psr\Http\Message\RequestInterface $request, array $options = []) : \Psr\Http\Message\ResponseInterface;
}
