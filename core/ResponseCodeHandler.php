<?php

namespace Core;

class ResponseCodeHandler
{
    public static function created($message = 'Created'): array
    {
        return [
            'code' => 201,
            'message' => $message,
        ];
    }

    public static function ok($message = 'OK'): array
    {
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
        throw new \Exception($message, 400);
    }

    /**
     * @throws \Exception
     */
    public static function unauthorized($message = 'Unauthorized'): array
    {
        throw new \Exception($message, 401);
    }

    /**
     * @throws \Exception
     */
    public static function forbidden($message = 'Forbidden'): array
    {
        throw new \Exception($message, 403);
    }

    /**
     * @throws \Exception
     */
    public static function notFound($message = 'Not Found'): array
    {
        throw new \Exception($message, 404);
    }

    /**
     * @throws \Exception
     */
    public static function internalServerError($message = 'Internal Server Error'): array
    {
        throw new \Exception($message, 500);
    }
}