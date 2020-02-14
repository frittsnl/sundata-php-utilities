<?php


namespace Sundata\Utilities\Rest;


class ApiRetrieverConfig
{
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
        return [
            'timeout' => $this->timeout,
            'read_timeout' => $this->readTimeout,
            'connect_timeout' => $this->connectTimeout
        ];
    }


    // Builder Methods
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

    function timeout(float $timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    // Getters
    public function getReadTimeout(): int
    {
        return $this->readTimeout;
    }

    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getName(): string
    {
        return $this->name;
    }
}