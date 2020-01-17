<?php


namespace Sundata\Utilities\Rest;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ApiRetriever
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    protected function restGet($url, $fullResponse = false)
    {
        $response = $this->apiCall('GET', $url);
        return $fullResponse ? $response : $response->getBody();
    }

    protected function restPost($url, $payload, $fullResponse = false)
    {
        $response = $this->apiCall('POST', $url, $payload);
        return $fullResponse ? $response : $response->getBody();
    }

    protected function apiCall(string $verb, $url, $payload = []): string
    {
        Log::debug("$verb on $url w payload: " . json_encode($payload));
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

        return $response;
    }

    private function logAndThrowThirdPartyApiException(string $message)
    {
        Log::error("ThirdPartyApiException: $message");
        throw new RuntimeException($message);
    }
}
