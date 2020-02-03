<?php

use App\Core\Model;
use App\Core\Router;

//Начало сессии
session_start();

$model = new Model();
$router = new Router();
$router->index();