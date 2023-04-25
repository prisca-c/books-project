<?php

namespace Routes;

use Core\Auth;

class Middleware
{
    public static function headers(): void
    {
        header("Access-Control-Allow-Origin: " . $_ENV['DOMAIN']);
        header("Content-Type': 'application/json");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");
    }

    /**
     * @throws \Exception
     */
    public static function verifyCookieHeader(): false|array
    {
        if (!isset($_COOKIE['cookie-session'])) {
            $cookie = null;
        } else {
            $cookie = $_COOKIE['cookie-session'];
        }

        if($_COOKIE) {
            if (!Auth::verifyToken($cookie)) {
                return false;
            }
            return Auth::decodeToken($cookie);
        }
        return false;
    }
}