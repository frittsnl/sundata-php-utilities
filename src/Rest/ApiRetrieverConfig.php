<?php


namespace Sundata\Utilities\Rest;


class ApiRetrieverConfig
{
    // DEFAULTS
    public $readTimeout = 60;
    public $connectTimeout = 60;
    public $timeout = 60;
    public $name = "ApiRetriever";

    public function __construct()
    {
        // empty
    }

    function toGuzzleConfig()
    {
        // See http://docs.guzzlephp.org/en/stable/request-options.html
        return [
            'timeout' => $this->timeout,
            'read_timeout' => $this->readTimeout,
            'connect_timeout' => $this->connectTimeout
        ];
    }

    function __toString()
    {
        return __CLASS__ . ";" . json_encode($this);
    }

    function name(string $name)
    {
        $this->name = $name;
        return $this;
    }

    function readTimeoutInSeconds(float $readTimeout)
    {
        $this->readTimeout = $readTimeout;
        return $this;
    }

    function connectTimeoutInSeconds(float $connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
        return $this;
    }

    function timeoutInSeconds(float $timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }
}