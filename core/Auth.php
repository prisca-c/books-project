<?php

declare(strict_types=1);

namespace Core;

use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{

    public static function generateToken(int|string $id): string
    {
        $secret = $_ENV['SECRET_KEY'];
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+1 day')->getTimestamp();
        $serverName = $_ENV['DOMAIN'];

        $payload = [
            'iat'  => $issuedAt->getTimestamp(),
            'iss'  => $serverName,
            'nbf'  => $issuedAt->getTimestamp(),
            'exp'  => $expire,
            'id'   => $id
        ];

        $JWT = JWT::encode($payload, $secret, 'HS256');

        if (Cache::redis()->get('auth:users:'.$id))
        {
            Cache::redis()->del('auth:users:'.$id);
        }

        Cache::redis()->set('auth:users:'.$id, $JWT, 86400);

        return $JWT;
    }

    public static function verifyToken(string $token): bool
    {
        $secret = $_ENV['SECRET_KEY'];
        $checkToken = self::decodeToken($token);

        if($checkToken)
        {
            if(Cache::redis()->get('auth:users:'.$checkToken['id']) === $token)
            {
                try {
                    $decoded = JWT::decode($token, new Key($secret, 'HS256'));
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
            }
        }
        return false;
    }

    public static function decodeToken(string $token): array|false
    {
        try {
            $decoded = JWT::decode($token, new Key($_ENV['SECRET_KEY'], 'HS256'), ['HS256']);
            return (array)$decoded;
        } catch (\Exception $e) {
            return false;
        }

    }
}