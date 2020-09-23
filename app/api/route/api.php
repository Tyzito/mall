<?php

use think\facade\Route;

Route::post('sendCode','sms/code');

Route::resource('user','User');