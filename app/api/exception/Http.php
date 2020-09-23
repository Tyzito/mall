<?php
namespace app\api\exception;


use think\Exception;
use think\exception\Handle;
use think\exception\HttpResponseException;
use think\Response;
use Throwable;

class Http extends Handle
{
    public $httpCode = 500;

    public function render($request, Throwable $e): Response
    {
        if($e instanceof Exception){
            return show($e->getCode(),$e->getMessage());
        }

        if($e instanceof HttpResponseException){
            return parent::render($request, $e);
        }

        if(method_exists($e, 'getStatusCode')){
            $httpCode = $e->getStatusCode();
        }else{
            $httpCode = $this->httpCode;
        }

        return show(config('status.error'), $e->getMessage(), [], $httpCode);
    }
}