<?php

namespace Core;

class ResponseCodeHandler
{
    public static function created($message = 'Created', $cookie=['value'=>'', 'name'=>'', 'expires'=>'', 'max-age'=>'']): array
    {
        http_response_code(201);
        if($cookie['value'] !== ''){
            header('Set-Cookie: ' . $cookie['name'] . '='. $cookie['value'] . '; Max-Age='. $cookie['max-age'] . '; HttpOnly; Secure; SameSite=strict; Path="./"');
        }
        return [
            'code' => 201,
            'message' => $message,
        ];
    }

    public static function ok($message = 'OK', $cookie=['value'=>'', 'name'=>'', 'expires'=>'', 'max-age'=>'']): array
    {
        http_response_code(200);
        if($cookie['value'] !== ''){
            header('Set-Cookie: ' . $cookie['name'] . '='. $cookie['value'] . '; Max-Age='. $cookie['max-age'] . '; HttpOnly; Secure; SameSite=strict; Path="./"');
        }
        return [
            'code' => 200,
            'message' => $message,
        ];
    }

    /**
     * @throws \Exception
     */
    public static function badRequest($message = 'Bad Request'): array
    {
        http_response_code(400);
        throw new \Exception($message, 400);
    }

    /**
     * @throws \Exception
     */
    public static function unauthorized($message = 'Unauthorized'): array
    {
        http_response_code(401);
        throw new \Exception($message, 401);
    }

    /**
     * @throws \Exception
     */
    public static function forbidden($message = 'Forbidden'): array
    {
        http_response_code(403);
        throw new \Exception($message, 403);
    }

    /**
     * @throws \Exception
     */
    public static function notFound($message = 'Not Found', $cookie=['value'=>'', 'name'=>'', 'expires'=>'', 'max-age'=>'']): array
    {
        http_response_code(404);
        if($cookie['value'] !== ''){
            header('Set-Cookie: ' . $cookie['name'] . '='. $cookie['value'] . '; Max-Age='. $cookie['max-age'] . '; HttpOnly; Secure; SameSite=strict; Path="./"');
        }
        throw new \Exception($message, 404);
    }

    /**
     * @throws \Exception
     */
    public static function internalServerError($message = 'Internal Server Error'): array
    {
        http_response_code(500);
        throw new \Exception($message, 500);
    }
}