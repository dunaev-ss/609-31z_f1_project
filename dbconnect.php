<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env'))
{
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

try
{
    $conn = new PDO(
        "mysql:host=" . $_ENV['dbhost'] . ";dbname=" . $_ENV['dbname'] . ";charset=utf8mb4",
        $_ENV['dbuser'],
        $_ENV['dbpassword']
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo "Ошибка подключения к БД: " . $e->getMessage(), $e->getCode();
    die();
}