<?php
// 应用公共文件

/**
 * 通用化API数据格式输出
 * @param $status
 * @param string $message
 * @param array $result
 * @param int $httpCode
 * @return \think\response\Json
 */
function show($status, $message = 'error', $result = [], $httpCode = 200)
{
    $result = [
        'status' => $status,
        'message' => $message,
        'result' => $result
    ];

    return json($result, $httpCode);
}