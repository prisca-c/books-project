<?php

namespace Core;

class ResponseCodeHandler
{
    public static function created($message = 'Created'): array
    {
        http_response_code(201);
        return [
            'code' => 201,
            'message' => $message,
        ];
    }

    public static function ok($message = 'OK'): array
    {
        http_response_code(200);
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
    public static function notFound($message = 'Not Found'): array
    {
        http_response_code(404);
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