<?php
declare(strict_types = 1);

namespace app\admin\middleware;


class Auth
{
    public function handle($request, \Closure $next)
    {
        // 前置中间件
        if(empty(session(config('admin.session_admin'))) && !preg_match('/login/',$request->pathinfo())){
            return redirect((string)url('login/index'));
        }

        return $next($request);

        // 后置中间件
        /*$response = $next($request);

        if(empty(session(config('admin.session_admin'))) && $request->controller() != 'Login'){
            return redirect((string)url('login/index'));
        }

        return $response;*/
    }
}