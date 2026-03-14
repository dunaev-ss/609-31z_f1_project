<?php

// Подключаем автозагрузчик Composer для автоматического подключения классов
require __DIR__ . '/vendor/autoload.php';

// Импортируем класс Dotenv из библиотеки vlucas/phpdotenv
use Dotenv\Dotenv;

// Проверяем, существует ли файл .env в текущей директории
if (file_exists(__DIR__ . '/.env'))
{
    // Создаём экземпляр Dotenv для работы с файлом .env
    $dotenv = Dotenv::createImmutable(__DIR__);
    
    // Загружаем переменные из .env в суперглобальный массив $_ENV
    $dotenv->load();
}

// Пытаемся установить соединение с базой данных
try
{
    // Формируем строку подключения (DSN) для PDO:
    // - указываем драйвер (mysql)
    // - задаём хост из переменной окружения dbhost
    // - указываем имя базы данных из dbname
    // - устанавливаем кодировку utf8mb4
    $conn = new PDO(
        "mysql:host=" . $_ENV['dbhost'] . ";dbname=" . $_ENV['dbname'] . ";charset=utf8mb4",
        $_ENV['dbuser'],      // логин пользователя из переменной dbuser
        $_ENV['dbpassword']   // пароль из переменной dbpassword
    );
    
    // Устанавливаем режим обработки ошибок PDO: выбрасывать исключения при ошибках
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    // В случае ошибки подключения:
    // - выводим сообщение об ошибке
    // - выводим код ошибки
    // - прекращаем выполнение скрипта
    echo "Ошибка подключения к БД: " . $e->getMessage(), $e->getCode();
    die();
}