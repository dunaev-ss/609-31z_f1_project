<?php

// Подключение автозагрузчика Composer для управления зависимостями
require __DIR__ . '/vendor/autoload.php';

// Импорт класса Dotenv для работы с переменными окружения
use Dotenv\Dotenv;

// Загрузка переменных окружения из .env-файла 
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

try {
    // Установка соединения с базой данных MySQL
    // Параметры подключения берутся из переменных окружения .env-файла
    $conn = new PDO(
        "mysql:host=" . $_ENV['dbhost'] . 
        ";dbname=" . $_ENV['dbname'] .
        ";charset=utf8mb4",
        $_ENV['dbuser'],
        $_ENV['dbpassword']
    );

    // Настройка режима обработки ошибок
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Вывод сообщения об ошибке подключения к базе данных
    echo "Ошибка подключения к базе данных: " . $e->getMessage() . ", код: " . $e->getCode();
    die();
}