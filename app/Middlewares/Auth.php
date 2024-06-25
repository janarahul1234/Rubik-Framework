<?php

namespace App\Middlewares;

use App\core\utils\Cookies;
use App\core\utils\JwtToken;

class Auth
{
    public static function verifyUser(): mixed
    {
        $token = '';
        
        if (Cookies::isSetCookie('Authorization')) {
            $token = Cookies::getCookie('Authorization');
        }

        return JwtToken::validate($token);
    }
}