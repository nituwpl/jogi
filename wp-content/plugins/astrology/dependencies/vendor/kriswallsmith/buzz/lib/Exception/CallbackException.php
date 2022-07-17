<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Exception;

use Psr\Http\Client\RequestExceptionInterface as PsrRequestException;
use Psr\Http\Message\RequestInterface;
/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class CallbackException extends \Prokerala\Astrology\Vendor\Buzz\Exception\ClientException implements \Psr\Http\Client\RequestExceptionInterface
{
    private $request;
    public function __construct(\Psr\Http\Message\RequestInterface $request, string $message = '', int $code = 0, \Throwable $previous = null)
    {
        $this->request = $request;
        parent::__construct($message, $code, $previous);
    }
    public function getRequest() : \Psr\Http\Message\RequestInterface
    {
        return $this->request;
    }
}
