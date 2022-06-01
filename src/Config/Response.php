<?php

declare(strict_types=1);

namespace NiceOpeningLaravel\Config;

class Response
{

    const Y_CODE_EN = '0';

    const Y_CODE = ['errcode' => 0, 'data' => [], 'message' => '成功'];


    // interface
    const INTERFACE_ERR = ['errcode' => 500001, 'data' => [], 'message' => '接口不存在']; // Interface does not exist


    // options subscript
    const OPTIONS_MODULE = ['errcode' => 500100, 'data' => [], 'message' => '选项错误：模块名称不存在']; //options error ：Module name does not exist
    const OPTIONS_MODULE_OPERATE = ['errcode' => 500101, 'data' => [], 'message' => '选项错误：模块操作不存在']; //options error ：Module operate does not exist


    // params must
    const PARAMS_MUST_ERR = ['errcode' => 500200, 'data' => [], 'message' => '参数错误：未填写必需的参数']; //parameter error : Required parameters are not filled

    // params format
    const PARAMS_FORMAT_ERR = ['errcode' => 500240, 'data' => [], 'message' => '参数错误：参数格式不正确']; //parameter error : Incorrect parameter format



}

