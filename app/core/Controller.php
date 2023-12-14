<?php

    namespace App\Core;

    use App\Models\HeaderModel;

    class Controller
    {
        private $headerModel;

        public function __construct()
        {
            $this->headerModel = new HeaderModel();
        }

        public function init()
        {
            $data['header'] = Router::render('layouts/header',
                [
                    'styles' => ['bootstrap.min', 'main.min'],
                    'menu' => $this->headerModel->getMenu()
                ]);

            $data['footer'] = Router::render('layouts/footer',
                ['scripts' => ['main']]);

            return $data;
        }
    }