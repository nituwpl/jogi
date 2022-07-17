<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim-Psr7/blob/master/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Slim\Psr7;

use Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Prokerala\Astrology\Vendor\Slim\Psr7\Factory\StreamFactory;
use Prokerala\Astrology\Vendor\Slim\Psr7\Interfaces\HeadersInterface;
use function is_integer;
use function is_object;
use function is_string;
use function method_exists;
class Response extends \Prokerala\Astrology\Vendor\Slim\Psr7\Message implements \Psr\Http\Message\ResponseInterface
{
    /**
     * @var int
     */
    protected $status = \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_OK;
    /**
     * @var string
     */
    protected $reasonPhrase = '';
    /**
     * @var array
     */
    protected static $messages = [
        // Informational 1xx
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_CONTINUE => 'Continue',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_SWITCHING_PROTOCOLS => 'Switching Protocols',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PROCESSING => 'Processing',
        // Successful 2xx
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_OK => 'OK',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_CREATED => 'Created',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_ACCEPTED => 'Accepted',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NO_CONTENT => 'No Content',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_RESET_CONTENT => 'Reset Content',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PARTIAL_CONTENT => 'Partial Content',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_MULTI_STATUS => 'Multi-Status',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_ALREADY_REPORTED => 'Already Reported',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_IM_USED => 'IM Used',
        // Redirection 3xx
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_MULTIPLE_CHOICES => 'Multiple Choices',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_MOVED_PERMANENTLY => 'Moved Permanently',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_FOUND => 'Found',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_SEE_OTHER => 'See Other',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NOT_MODIFIED => 'Not Modified',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_USE_PROXY => 'Use Proxy',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_RESERVED => '(Unused)',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_TEMPORARY_REDIRECT => 'Temporary Redirect',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PERMANENT_REDIRECT => 'Permanent Redirect',
        // Client Error 4xx
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_BAD_REQUEST => 'Bad Request',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_UNAUTHORIZED => 'Unauthorized',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PAYMENT_REQUIRED => 'Payment Required',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_FORBIDDEN => 'Forbidden',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NOT_FOUND => 'Not Found',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_METHOD_NOT_ALLOWED => 'Method Not Allowed',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NOT_ACCEPTABLE => 'Not Acceptable',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_REQUEST_TIMEOUT => 'Request Timeout',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_CONFLICT => 'Conflict',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_GONE => 'Gone',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_LENGTH_REQUIRED => 'Length Required',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PRECONDITION_FAILED => 'Precondition Failed',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PAYLOAD_TOO_LARGE => 'Request Entity Too Large',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_URI_TOO_LONG => 'Request-URI Too Long',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_RANGE_NOT_SATISFIABLE => 'Requested Range Not Satisfiable',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_EXPECTATION_FAILED => 'Expectation Failed',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_IM_A_TEAPOT => 'I\'m a teapot',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_MISDIRECTED_REQUEST => 'Misdirected Request',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY => 'Unprocessable Entity',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_LOCKED => 'Locked',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_FAILED_DEPENDENCY => 'Failed Dependency',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_UPGRADE_REQUIRED => 'Upgrade Required',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_PRECONDITION_REQUIRED => 'Precondition Required',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_TOO_MANY_REQUESTS => 'Too Many Requests',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',
        444 => 'Connection Closed Without Response',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable For Legal Reasons',
        499 => 'Client Closed Request',
        // Server Error 5xx
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NOT_IMPLEMENTED => 'Not Implemented',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_BAD_GATEWAY => 'Bad Gateway',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE => 'Service Unavailable',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_GATEWAY_TIMEOUT => 'Gateway Timeout',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_INSUFFICIENT_STORAGE => 'Insufficient Storage',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_LOOP_DETECTED => 'Loop Detected',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NOT_EXTENDED => 'Not Extended',
        \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error',
    ];
    /**
     * @param int                   $status  The response status code.
     * @param HeadersInterface|null $headers The response headers.
     * @param StreamInterface|null  $body    The response body.
     */
    public function __construct(int $status = \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_OK, ?\Prokerala\Astrology\Vendor\Slim\Psr7\Interfaces\HeadersInterface $headers = null, ?\Psr\Http\Message\StreamInterface $body = null)
    {
        $this->status = $this->filterStatus($status);
        $this->headers = $headers ? $headers : new \Prokerala\Astrology\Vendor\Slim\Psr7\Headers([], []);
        $this->body = $body ? $body : (new \Prokerala\Astrology\Vendor\Slim\Psr7\Factory\StreamFactory())->createStream();
    }
    /**
     * This method is applied to the cloned object after PHP performs an initial shallow-copy.
     * This method completes a deep-copy by creating new objects for the cloned object's internal reference pointers.
     */
    public function __clone()
    {
        $this->headers = clone $this->headers;
    }
    /**
     * {@inheritdoc}
     */
    public function getStatusCode() : int
    {
        return $this->status;
    }
    /**
     * {@inheritdoc}
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $code = $this->filterStatus($code);
        $reasonPhrase = $this->filterReasonPhrase($reasonPhrase);
        $clone = clone $this;
        $clone->status = $code;
        $clone->reasonPhrase = $reasonPhrase;
        return $clone;
    }
    /**
     * {@inheritdoc}
     */
    public function getReasonPhrase() : string
    {
        if ($this->reasonPhrase !== '') {
            return $this->reasonPhrase;
        }
        if (isset(static::$messages[$this->status])) {
            return static::$messages[$this->status];
        }
        return '';
    }
    /**
     * Filter HTTP status code.
     *
     * @param  int $status HTTP status code.
     *
     * @return int
     *
     * @throws InvalidArgumentException If an invalid HTTP status code is provided.
     */
    protected function filterStatus($status) : int
    {
        if (!\is_integer($status) || $status < \Prokerala\Astrology\Vendor\Fig\Http\Message\StatusCodeInterface::STATUS_CONTINUE || $status > 599) {
            throw new \InvalidArgumentException('Invalid HTTP status code.');
        }
        return $status;
    }
    /**
     * Filter Reason Phrase
     *
     * @param mixed $reasonPhrase
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function filterReasonPhrase($reasonPhrase = '') : string
    {
        if (\is_object($reasonPhrase) && \method_exists($reasonPhrase, '__toString')) {
            $reasonPhrase = (string) $reasonPhrase;
        }
        if (!\is_string($reasonPhrase)) {
            throw new \InvalidArgumentException('Response reason phrase must be a string.');
        }
        if (\strpos($reasonPhrase, "\r") || \strpos($reasonPhrase, "\n")) {
            throw new \InvalidArgumentException('Reason phrase contains one of the following prohibited characters: \\r \\n');
        }
        return $reasonPhrase;
    }
}
