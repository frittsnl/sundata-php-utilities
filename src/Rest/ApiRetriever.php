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

    public function restGet($url, $options = [], $fullResponse = false)
    {
        $response = $this->apiCall('GET', $url, [], $options);
        return $fullResponse ? $response : $response->getBody()->getContents();
    }

    public function restPost($url, $payload, $options = [], $fullResponse = false)
    {
        $response = $this->apiCall('POST', $url, $payload, $options);
        return $fullResponse ? $response : $response->getBody()->getContents();
    }

    public function apiCall(string $verb, $url, $payload = [], $options = [], $validStatusCodes = [200]) : ResponseInterface
    {
        Log::debug("$verb on $url w payload: " . json_encode($payload) . ' and options: ' . json_encode($options));

        $defaultOptions = [
            'headers' => [],
            'exceptions' => false,
            'json' => $payload
        ];

        $options = array_merge($defaultOptions, $options);

        try {
            $response = (new Client())->request(
                $verb,
                $url,
                $options
            );

        } catch (GuzzleException $e) {
            $this->logAndThrowThirdPartyApiException("Exception reaching $this->name");
        }

        if (count($validStatusCodes) &&  !in_array($response->getStatusCode(), $validStatusCodes)) {
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
