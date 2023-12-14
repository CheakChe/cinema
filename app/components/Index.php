<?php

    namespace App\Components;


    use App\Core\AbstractController;
    use App\Core\Log;
    use App\Core\Router;

    class Index extends AbstractController
    {

        public function index()
        {
            return Router::render('main');
        }

    }