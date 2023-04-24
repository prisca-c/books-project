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
        $expire     = $issuedAt->modify('+6 minutes')->getTimestamp();
        $serverName = $_ENV['DOMAIN'];

        $payload = [
            'iat'  => $issuedAt->getTimestamp(),
            'iss'  => $serverName,
            'nbf'  => $issuedAt->getTimestamp(),
            'exp'  => $expire,
            'id'   => $id
        ];

        $JWT = JWT::encode($payload, $secret, 'HS256');

        if (Cache::get('auth:users:'.$id))
        {
            Cache::del('auth:users:'.$id);
        }

        Cache::set('auth:users:'.$id, $JWT, 7200); // 2 hours

        return $JWT;
    }

    public static function verifyToken(string $token): bool
    {
        $secret = $_ENV['SECRET_KEY'];
        try {
            $decoded = JWT::decode($token, new Key($secret,'HS256'));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}