<?php

declare(strict_types=1);

namespace NiceOpeningLaravel\Https;

use NiceOpeningLaravel\Config\Apis;
use NiceOpeningLaravel\Config\Response;
use NiceOpeningLaravel\Traits\MakesHttpRequests;

/**
 * Class HttpCore
 * Handle the HTTP request
 *
 */
class HttpCore
{
    use MakesHttpRequests;

    /**
     * @var string generated header authorization
     */
    private $authorization;

    /**
     * @var array ask api options
     */
    private $options;

    /**
     * @var array ask api params data
     */
    private $data;

    const FIRST_ASK_METHOD = 0;


    public function __construct(string $authorization, array $options, array $data)
    {
        $this->authorization = $authorization;
        $this->optins = $options;
        $this->data = $data;
    }

    /**
     * Method makeApiRequest
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * author: dengtao
     * date: 2021/10/19 11:39
     */
    public function makeApiRequest(): array
    {
        $check = Apis::checkApi($this->optins,$this->data);

        if ($check['errcode'] == Response::Y_CODE_EN) {
            $apis = Apis::getApis($this->optins);

            $method = $apis['method'][self::FIRST_ASK_METHOD];

            return $this->request($apis['url'], $this->data, $method);
        } else {
            return $check;
        }
    }
}