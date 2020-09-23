<?php
namespace app\demo\exception;


use think\exception\Handle;
use think\Response;
use Throwable;

class Http extends Handle
{
    public $httpCode = 500;

    public function render($request, Throwable $e): Response
    {
        if(method_exists($e, 'getStatusCode')){
            $httpCode = $e->getStatusCode();
        }else{
            $httpCode = $this->httpCode;
        }

        return show(config('status.error'), $e->getMessage(), [], $httpCode);
    }
}