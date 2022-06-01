<?php

namespace NiceOpeningLaravel\Tests;

use NiceOpeningLaravel\NiceExternal;
use PHPUnit\Framework\TestCase;
class NiceTest extends TestCase
{
    private $accessKeyId;
    private $accessKeySecret;
    private $niceExternal;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->accessKeyId = "请替换为您的appid";
        $this->accessKeySecret = "请替换为您的secret";

        $this->niceExternal = new NiceExternal($this->accessKeyId, $this->accessKeySecret);
    }

    public function test()
    {
        $res = $this->niceExternal->dealRequest('project_list', []);
        var_dump($res);die;
    }
}