<?php

declare(strict_types=1);

namespace NiceOpeningLaravel\Config;

use function Couchbase\defaultDecoder;

/**
 * Class Apis
 *
 *Class for nice apis.The caller could use it to get the Apis they need including params,method and url.
 *
 */
class Apis
{
    const BASE_URL = "https://nice.zebra-c.com/api/";

    const METHOD_GET = "GET";
    const METHOD_POST = "POST";

    const OPTION_TYPE_CODE = 0;
    const OPTION_QUERY_CODE = 1;


    /**
     * @var array
     */
    private static $apis = [
        "project" => [
            "create" => [
                "params" => [
                    "project_name" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "参数支持中文，数字，英文字母大小写，下划线\"_\"，中横线\"-\"，&符号，中英文的小括号；长度100字符"
                    ],
                    "data_type" => [
                        "type" => "int",
                        "is_must" => true,
                        "description" => "项目数据类型：1单角色语音、2多角色语音、3单角色文本、4多角色文本"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ],
            ],
            "modify" => [
                "params" => [
                    "project_key" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "项目key标识"
                    ],
                    "project_name" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "参数支持中文，数字，英文字母大小写，下划线\"_\"，中横线\"-\"，&符号，中英文的小括号；长度100字符"
                    ]
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ],
            "list" => [
                "params" => [],
                "method" => [
                    self::METHOD_GET,
                    self::METHOD_POST
                ]
            ],
            "executeModeList" => [
                "params" => [],
                "method" => [
                    self::METHOD_GET,
                    self::METHOD_POST
                ]
            ],
            "executeModeSet" => [
                "params" => [
                    "project_key" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "项目列表中返回的项目ID标识"
                    ],
                    "execute_id" => [
                        "type" => "int",
                        "is_must" => true,
                        "description" => "项目可用执行方式列表中返回的执行方式ID标识"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ],
            "kpiSet" => [
                "params" => [
                    "project_key" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "项目列表中返回的项目ID标识"
                    ],
                    "kpi_code_list" => [
                        "type" => "array",
                        "is_must" => true,
                        "description" => "项目可用指标列表中kpi_code字段组合的数组，如[\"A00000025\",\"A00000026\"]"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ],
            "kpiList" => [
                "params" => [
                    "project_key" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "项目列表中返回的项目ID标识"
                    ],
                ],
                "method" => [
                    self::METHOD_GET
                ]
            ],
            "groupList" => [
                "params" => [],
                "method" => [
                    self::METHOD_GET
                ]
            ],
            "kpiCreate" => [
                "params" => [
                    "group_key" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "获取场景接口返回数据的group_key属性"
                    ],
                    "type" => [
                        "type" => "int",
                        "is_must" => true,
                        "description" => "指标属性：1，提及类；2，数值类；3，情感极向"
                    ],
                    "kpi2" => [
                        "type" => "string/int",
                        "is_must" => true,
                        "description" => "指标名称，长度限制1~20"
                    ],
                    "description" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "指标描述信息，长度1~100"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ]
        ],
        "kpi" => [
            "list" => [
                "params" => [
                    "project_key" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "项目唯一标识"
                    ],
                    "page" => [
                        "type" => "number",
                        "is_must" => false,
                        "description" => "当前页数，默认为1"
                    ],
                    "size" => [
                        "type" => "number",
                        "is_must" => false,
                        "description" => "获取条数，默认为10，最大不能超过100"
                    ],
                ],
                "method" => [
                    self::METHOD_GET
                ]
            ]
        ],
        "task" => [
            "create" => [
                "params" => [
                    "project_key" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "项目key，通过项目列表api获取",
                    ],
                    "ts" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "当前时间戳，从1970年1月1日0点0分0秒开始到现在的秒数"
                    ],
                    "task_type" => [
                        "type" => "int",
                        "is_must" => true,
                        "description" => "任务类型：1-录音；2-文本"
                    ],
                    "task_file_url" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "可访问的任务文件url（格式要求见下方表格），与task_file两者之间必须有一个"
                    ],
                    "task_file" => [
                        "type" => "file",
                        "is_must" => false,
                        "description" => "任务文件（格式要求见下方表格），与task_file_url两者之间必须有一个"
                    ],

                    "user_code" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "用户唯一标识，通过用户相关接口获取。
                        若携带该参数，且该用户在海王星APP上录入了声纹，则在任务分析时会使用该声纹"
                    ],
                    "rows" => [
                        "type" => "int",
                        "is_must" => false,
                        "description" => "文本行数，当任务类型 task_type 是 2（文本），需要该参数"
                    ],
                    "task_language_type" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "语音类型"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ],
            "getResult" => [
                "params" => [
                    "task_no" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "任务编号"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ],
            "getResultFile" => [
                "params" => [
                    "task_no" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "任务编号"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ]
        ],
        "user" => [
            "getServicePermission" => [
                "params" => [],
                "method" => [
                    self::METHOD_POST
                ]
            ],
            "saveVoice" => [
                "params" => [
                    "user_code" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "用户ID"
                    ],
                    "user_name" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "用户名"
                    ],
                    "voice_code" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "声纹ID"
                    ],
                    "voice_type" => [
                        "type" => "int",
                        "is_must" => true,
                        "description" => "声纹类型：1.文件 2.url。（新增时该字段必须传）"
                    ],
                    "url" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "声纹文件url"
                    ],
                    "file" => [
                        "type" => "file",
                        "is_must" => false,
                        "description" => "声纹文件"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ],
            "syncUser" => [
                "params" => [
                    "name" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "用户名"
                    ],
                    "phone" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "手机号"
                    ],
                    "email" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "email"
                    ],
                    "user_code" => [
                        "type" => "string",
                        "is_must" => true,
                        "description" => "用户唯一标识。（该值需要保证唯一）"
                    ],
                    "account" => [
                        "type" => "string",
                        "is_must" => false,
                        "description" => "登录密码。（需要经过双层md5加密，新增用户时必须传该字段）"
                    ],
                    "projects" => [
                        "type" => "array",
                        "is_must" => true,
                        "description" => "用户项目权限。（数组元素是项目的 project_key 字段值 ）"
                    ],
                    "permissions" => [
                        "type" => "array",
                        "is_must" => true,
                        "description" => "用户功能权限。（数组元素是权限列表接口返回中 children.id 字段值 ）"
                    ],
                    "status" => [
                        "type" => "int",
                        "is_must" => true,
                        "description" => "用户状态值。（1.待激活 2.启用 3.停用 ）"
                    ],
                ],
                "method" => [
                    self::METHOD_POST
                ]
            ]
        ]
    ];


    private static $language = [
        [
            "type" => "cn",
            "description" => "普通"
        ],
        [
            "type" => "cn_cantonese",
            "description" => "广东话"
        ],
        [
            "type" => "cn_henanese",
            "description" => "河南话"
        ],
        [
            "type" => "cn_xinanese",
            "description" => "西南官话（云贵川渝）"
        ],
        [
            "type" => "en",
            "description" => "en"
        ],
    ];

    /**
     * Method getApis
     *
     * The method to get Apis by type and query.
     *
     * @param array $options
     *
     * @return array
     * author: dengtao
     * date: 2021/10/15 16:53
     */
    public static function getApis(array $options): array
    {
        $url = implode('/', $options);
        return array_merge(
            self::$apis[$options[self::OPTION_TYPE_CODE]][$options[self::OPTION_QUERY_CODE]],
            ["url" => $url]
        );
    }

    /**
     * Method checkApi
     *
     * The method to check api exist.
     *
     * @param array $options
     * @return bool
     * author: dengtao
     * date: 2021/10/19 15:15
     */
    public static function checkApi(array $options, array $data): array
    {
        $type = $options[self::OPTION_TYPE_CODE];
        $query = $options[self::OPTION_QUERY_CODE];

        // Detection module
        if (!array_key_exists($type, self::$apis)) {
            return Response::OPTIONS_MODULE;
        }

        $newApis = self::$apis[$type];

        // Detection module operate
        if (!array_key_exists($query, $newApis)) {
            return Response::OPTIONS_MODULE_OPERATE;
        }

        $newQuery = $newApis[$query];

        // Required testing parameters
        $parameter_must = self::getMust($newQuery, $data);

        if ($parameter_must['errcode'] == Response::Y_CODE_EN) {

            // Detection parameter format
            $parameter_format = self::getType($newQuery, $data);

            return $parameter_format['errcode'] == Response::Y_CODE_EN ? Response::Y_CODE : Response::PARAMS_FORMAT_ERR;

        } else {

            return $parameter_must;
        }


    }

    /**
     * Method getLanguage
     *
     * Language type for task create
     *
     * @return array
     * author: dengtao
     * date: 2021/10/15 16:55
     */
    public static function getLanguage(): array
    {
        return self::$language;
    }

    /**
     * Method getMust
     *
     *Testing optional parameters
     *
     * @param array $querys
     * @param array $data
     * @return array
     */

    public static function getMust(array $querys, array $data): array
    {
        if (empty($querys['params'])) {
            return Response::Y_CODE;
        }
        // 获取数据中必传的参数
        $queryParamaNames = self::getMustDatas($querys);

        // 获取全部参数
        $formalParameters = array_keys($data);

        $IssetDiffFormalDatas = array_diff($queryParamaNames, $formalParameters);

        if ($IssetDiffFormalDatas) {
            $diffFormalDatas = implode(',', $IssetDiffFormalDatas);
            return array_merge(Response::PARAMS_MUST_ERR, ['message' => "参数错误：必需的参数 '" . $diffFormalDatas . "' 未填写"]);
        }

        return Response::Y_CODE;
    }

    /**
     * Method getType
     *
     * The format of the detected value
     *
     * @param array $querys
     * @param array $data
     * @return array
     */

    public static function getType(array $querys, array $data): array
    {
        foreach ($data as $data_key => $val) {

            if (isset($querys['params'][$data_key])) {

                if (strpos($querys['params'][$data_key]['type'], '/')) {
                    $typeParamses = explode('/', $querys['params'][$data_key]['type']);
                    $isFalseData = [];
                    foreach ($typeParamses as $typeParams) {
                        $isFormats = self::getParameterFormat($typeParams);
                        if (!$isFormats($val) || empty($isFormats)) {
                            $isFalseData[] = $typeParams;
                        }
                    }

                    if (count($typeParamses) == count($isFalseData)) {
                        return Response::PARAMS_FORMAT_ERR;
                    }

                } else {
                    $isFormat = self::getParameterFormat($querys['params'][$data_key]['type']);
                    if (!$isFormat($val)) {
                        return Response::PARAMS_FORMAT_ERR;
                    }
                }

            }
        }
        return Response::Y_CODE;
    }

    /**
     * Method getMustDatas
     *
     * The parameter name that must be passed in the data
     *
     * @param $querymust
     * @return array
     */

    public static function getMustDatas($querymust): array
    {
        $queryMustData = [];
        foreach ($querymust['params'] as $param_key => $param) {
            if ($param['is_must'] == true) {
                $queryMustData[] = $param_key;
            }
        }
        return $queryMustData;
    }


    /**
     * Method getMustDatas
     *
     * Parameter format verification
     *
     * @param $type
     * @return string
     */
    public static function getParameterFormat($type): string
    {
        $isFormat = '';
        if ($type == 'number') {
            $isFormat = 'is_numeric';
        } elseif (in_array($type, ['array', 'int', 'string'])) {
            $isFormat = 'is_' . $type;
        } else {
            //  return $isFormat;
        }
        return $isFormat;
    }

}
