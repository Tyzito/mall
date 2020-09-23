<?php


namespace app\demo\middleware;


class Check
{
    public function handle($request, \Closure $next)
    {
        dump(666);

        return $next($request);
    }
}