<?php

use App\Core\Router;

//Начало сессии
session_start();
//Конфигурационный файл — содержит  настройки БД
$_SESSION['DB'] = parse_ini_file('DB.ini');
//Создание переменной DNS для подключение к БД через PDO
$_SESSION['DB']['dns'] = $_SESSION['DB']['DB_CONNECTION'] . ':dbname=' . $_SESSION['DB']['DB_DATABASE'] . ';host=' . $_SESSION['DB']['DB_HOST'];
//Создание объекта БД
$DB = new PDO($_SESSION['DB']['dns'], $_SESSION['DB']['DB_USERNAME'], $_SESSION['DB']['DB_PASSWORD']);

$router = new Router($DB);
$router->index();