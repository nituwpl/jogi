<?php

/*
 * This file is part of Prokerala Astrology API PHP SDK
 *
 * © Ennexa Technologies <info@ennexa.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Prokerala\Common\Api;

use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\RetryableExceptionInterface;
use Prokerala\Common\Api\Exception\ServerException;
use Prokerala\Common\Api\Exception\ValidationException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
final class Client
{
    const BASE_URI = 'https://api.prokerala.com/v2/astrology/';
    private $authClient;
    private $httpClient;
    private $httpRequestFactory;
    private $apiCreditUsed = 0;
    /**
     * @param $authClient
     * @param $httpClient
     * @param $httpRequestFactory
     */
    public function __construct($authClient, $httpClient, $httpRequestFactory)
    {
        $this->authClient = $authClient;
        $this->httpClient = $httpClient;
        $this->httpRequestFactory = $httpRequestFactory;
    }
    /**
     * Query the API server.
     *
     * @internal
     *
     * @param string $path  section path
     * @param array  $input request parameters
     *
     * @return array
     */
    public function process($path, $input)
    {
        $uri = self::BASE_URI . $path . '?' . \http_build_query($input);
        $request = $this->httpRequestFactory->createRequest('GET', $uri);
        try {
            $request = $this->authClient->process($request);
            $response = $this->request($request);
            if (401 === $response->getStatusCode()) {
                $this->authClient->handleError($response->message, $response->code);
            }
        } catch (\Prokerala\Common\Api\Exception\RetryableExceptionInterface $e) {
            $request = $this->authClient->process($request);
            $response = $this->request($request);
        }
        $responseType = $response->getHeader('content-type');
        $responseBody = (string) $response->getBody();
        $apiCredits = $response->getHeader('X-Api-Credits');
        $this->apiCreditUsed = isset($apiCredits) ? (int) $apiCredits[0] : 0;
        if (isset($responseType[0]) && 'image/svg+xml' == $responseType[0]) {
            $responseData = $responseBody;
        } else {
            $responseData = \json_decode($responseBody);
        }
        switch ($response->getStatusCode()) {
            case 200:
                return $responseData;
            case 401:
                throw new \Prokerala\Common\Api\Exception\AuthenticationException($responseData->errors[0]->detail);
            case 400:
                throw new \Prokerala\Common\Api\Exception\ValidationException($responseData->errors);
            case 500:
                throw new \Prokerala\Common\Api\Exception\ServerException($responseData->errors[0]->detail);
            default:
                throw new \Prokerala\Common\Api\Exception\Exception($responseData->errors[0]->detail);
        }
    }
    /**
     * @return int
     */
    public function getCreditUsed()
    {
        return $this->apiCreditUsed;
    }
    /**
     * @return ResponseInterface
     */
    private function request(\Psr\Http\Message\RequestInterface $request)
    {
        return $this->httpClient->sendRequest($request);
    }
}
