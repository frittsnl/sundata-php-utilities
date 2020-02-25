<?php


namespace Sundata\Utilities\Rest;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class ApiRetriever
{
    /** @var ApiRetrieverConfig */
    private $config;

    /** @param ApiRetrieverConfig|null $config */
    public function __construct(ApiRetrieverConfig $config = null)
    {
        $this->config = $config ? clone $config : new ApiRetrieverConfig();
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

    public function apiCall(string $verb, $url, $payload = [], $options = [], $validStatusCodes = [200]): ResponseInterface
    {
        Log::debug("$verb on $url" . $this->logPayloadAndOptions($payload, $options));

        $defaultOptions = [
            'headers' => [],
            'exceptions' => false,
            'json' => $payload
        ];

        $options = array_merge($defaultOptions, $options);

        try {
            $guzzleClient = new Client($this->config->toGuzzleConfig());
            $response = $guzzleClient->request(
                $verb,
                $url,
                $options
            );

        } catch (GuzzleException $e) {
            $this->logAndThrowRuntimeApiException("Exception reaching {$this->config->name}", $url);
        }

        if (count($validStatusCodes) &&  !in_array($response->getStatusCode(), $validStatusCodes)) {
            $this->logAndThrowRuntimeApiException("{$this->config->name} returned {$response->getStatusCode()} : {$response->getBody()}", $url);
        }

        return $response;
    }

    private function logPayloadAndOptions(array $payload, array $options) : string
    {
        $string = '';
        $this->config->logPayload ? $string = $string . ' w payload: ' . json_encode($payload) : '';
        $this->config->logOptions ? $string = $string . ' w options: ' . json_encode($options) : '';
        return $string;
    }

    private function logAndThrowRuntimeApiException(string $message, string $url)
    {
        Log::info("Exception occurred while calling $url : $message");
        throw new RuntimeException($message);
    }
}
