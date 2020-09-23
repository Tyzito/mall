<?php
declare(strict_types = 1);

namespace app\common\lib\sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use think\facade\Log;

class AliSms implements SmsBase
{
    // 阿里云发送短信验证码
    public static function sendCode(string $phone, int $code):bool
    {
        AlibabaCloud::accessKeyClient(config('api.access_key_id'), config('api.access_secret'))
            ->regionId(config('api.region_id'))
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host(config('api.host'))
                ->options([
                    'query' => [
                        'RegionId' => config('api.region_id'),
                        'PhoneNumbers' => $phone,
                        'SignName' => config('api.sign_name'),
                        'TemplateCode' => config('api.template_code'),
                        'TemplateParam' => json_encode(["code" => $code]),
                    ],
                ])
                ->request();
            Log::info("alisms-sendCode-{$phone}-result".json_encode($result->toArray()));
            //print_r($result->toArray());
        } catch (ClientException $e) {
            Log::error("alisms-senCode-{$phone}-ClientException".$e->getErrorMessage());
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            Log::error("alisms-senCode-{$phone}-ServerException".$e->getErrorMessage());
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        }

        if(isset($result['Code']) && $result['Code'] == 'OK'){
            return true;
        }

        return false;
    }
}