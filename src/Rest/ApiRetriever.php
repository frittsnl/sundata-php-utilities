<?php


namespace Sundata\Utilities\Rest;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class ApiRetriever
{
    /** @var string */
    private $name;

    /**
     * ApiRetriever constructor.
     * @param string $name For logging purposes. Default is 'ApiRetriever'
     */
    public function __construct(string $name = "ApiRetriever")
    {
        $this->name = $name;
    }

    public function restGet($url, $fullResponse = false)
    {
        $response = $this->apiCall('GET', $url);
        return $fullResponse ? $response : $response->getBody();
    }

    public function restPost($url, $payload, $fullResponse = false)
    {
        $response = $this->apiCall('POST', $url, $payload);
        return $fullResponse ? $response : $response->getBody();
    }

    public function apiCall(string $verb, $url, $payload = []) : ResponseInterface
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
