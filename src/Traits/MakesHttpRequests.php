<?php

declare(strict_types=1);

namespace NiceOpeningLaravel\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use NiceOpeningLaravel\Config\Apis;
use NiceOpeningLaravel\Config\Response;
use NiceOpeningLaravel\Exceptions\NiceException;

/**
 * Trait MakesHttpRequests
 * Handle the HTTP request using client and manages the responses.
 *
 */
trait MakesHttpRequests
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    private static $contentType = "application/json";

    /**
     * Method request
     *
     * @param $endpoint
     * @param array $payload
     * @param string $method
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($endpoint, array $payload, $method = "POST")
    {
        $headers = [
            'Authorization' => $this->authorization,
        ];

        if ($method == 'POST') {
            $headers['Content-Type'] = self::$contentType;
        }

        $request_info = [
            'headers' => $headers,
        ];

        if ($payload && $payload != []) {
            if ($method == 'POST') {
                $request_info['json'] = $payload;
            } else {
                $request_info['query'] = $payload;
            }
        }
        try {
            $response = $this->getHttpClient()->request($method, $endpoint, $request_info);
            return $this->parseResponse($response);
        } catch (\Exception $e) {
            $errResponse = [
                "errcode" => $e->getCode(),
                'data'=>[],
                "message" => $e->getMessage(),
            ];
            return $errResponse;
        }
    }

    /**
     * Convert the object result to an array
     *
     * @param object $response
     * @return array
     */
    protected function parseResponse(object $response): array
    {
        $result = json_decode((string) $response->getBody(), true);
        if (empty($result)){
            return Response::INTERFACE_ERR;
        }
        return $result;
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function getHttpClient(): ClientInterface
    {
        return $this->httpClient ?: $this->httpClient = new Client([
            'base_uri' => Apis::BASE_URL,
        ]);
    }

}
