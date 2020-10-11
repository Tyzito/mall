<?php


namespace app\demo\middleware;


class Check
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}