<?php

    use App\Core\Router;

    session_start();
    (new Router())->init();
    session_write_close();

