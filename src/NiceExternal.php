<?php

declare(strict_types=1);

namespace NiceOpeningLaravel;

use NiceOpeningLaravel\Https\HttpCore;
use Firebase\JWT\JWT;
use NiceOpeningLaravel\Exceptions\NiceException;
use NiceOpeningLaravel\Traits\MakesHttpRequests;
/**
 * Class NiceExternal
 *
 * Nice external platforms use interface classes, which encapsulate all the Nice apis that external platforms can call to talk to Nice
 * For more details, please check out the NICE API document:https://testnice.zebra-c.com/storage/document/
 */
class NiceExternal
{
    use MakesHttpRequests;

    /**
     * @var string app_id
     */
    private $accessKeyId;

    /**
     * @var string secret
     */
    private $accessKeySecret;

    /**
     * @var string alg
     */
    private $alg;

    /**
     * @var string header encrypt type
     */
    private $typ;

    /**
     * @var string generated header authorization
     */
    private $authorization;

    const JWT_START_CODE = "Bearer";

    /**
     * Constructor
     *
     * There're a few different ways to create an Nice object:
     * 1. By access Id, access Key: $Nice = new NiceExternal($id, $key)
     *
     * @param string $accessKeyId The AccessKeyId from NICE
     * @param string $accessKeySecret The AccessKeySecret from NICE
     * @param array $params
     * @param string $alg
     * @param string $typ
     * @throws NiceException
     */
    public function __construct(string $accessKeyId, string $accessKeySecret, string $alg = "HS256", string $typ = "JWT")
    {
        $accessKeyId = trim($accessKeyId);
        $accessKeySecret = trim($accessKeySecret);

        if (empty($accessKeyId)) {
            throw new NiceException("access key id is empty");
        }
        if (empty($accessKeySecret)) {
            throw new NiceException("access key secret is empty");
        }

        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->alg = $alg;
        $this->typ = $typ;
        $this->authorization = self::generateJwtHeader();
    }

    /**
     * Deal with header
     * @return string
     */
    private function generateJwtHeader(): string
    {
        $header = [
            "alg" => $this->alg,
            "typ" => $this->typ
        ];

        $payload = [
            'app_id' => $this->accessKeyId,
            'iat' => time(),
        ];

        $secret = $this->accessKeySecret;

        return self::JWT_START_CODE . ' ' . JWT::encode($payload, $secret,$this->alg);
    }

    /**
     * deal with the request for nice interfaces
     *
     * @param string $key
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * author: dengtao
     * date: 2021/10/19 11:41
     */
    public function dealRequest(string $key, array $data): array
    {
        $options = explode('_', $key);
        $projectCore = new HttpCore($this->authorization, $options, $data);
        return $projectCore->makeApiRequest();
    }
}