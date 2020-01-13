<?php


namespace Sundata\Utilities\Rest;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use RuntimeException;

abstract class ApiRetriever
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    protected function restGet($url): string
    {
        return $this->apiCall('GET', $url);
    }

    protected function restPost($url, $payload): string
    {
        return $this->apiCall('POST', $url, $payload);
    }

    protected function apiCall(string $verb, $url, $payload = []): string
    {
      Log::debug("$verb on $url w payload: $payload");
        try {
            $response = (new Client())->request(
                $verb,
                $url,
                [
                    'headers' => [],
                    'exceptions' => false,
                    'json' => $payload
                ]
            );

        } catch (GuzzleException $e) {
            $this->logAndThrowThirdPartyApiException("Exception reaching $this->name");
        }

        if ($response->getStatusCode() != 200) {
            $this->logAndThrowThirdPartyApiException("$this->name returned {$response->getStatusCode()} : {$response->getBody()}");
        }

        return $response->getBody();
    }

    private function logAndThrowThirdPartyApiException(string $message)
    {
        Log::error("ThirdPartyApiException: $message");
        throw new RuntimeException($message);
    }
}
