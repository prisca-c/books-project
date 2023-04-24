<?php

namespace Config;

class database_config
{
    private string $db_name;
    private string $db_host;
    private string $db_user;
    private string $db_password;

    public function __construct()
    {
        $this->db_name = $_ENV['DB_DATABASE'];
        $this->db_host = $_ENV['DB_HOST'];
        $this->db_user = $_ENV['DB_USER'];
        $this->db_password = $_ENV['DB_PASSWORD'];
    }

    public static function getDbName(): string
    {
        return (new self())->db_name;
    }

    public static function getDbHost(): string
    {
        return (new self())->db_host;
    }

    public static function getDbUser(): string
    {
        return (new self())->db_user;
    }

    public static function getDbPassword(): string
    {
        return (new self())->db_password;
    }
}