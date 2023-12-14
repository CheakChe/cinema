<?php

    namespace App\Core;

    class Router
    {
        private $url, $error = true;

        public function __construct()
        {
            $this->url = explode('/', $_SERVER['REQUEST_URI']);
        }

        public static function render($template, $vars = NULL)
        {
            if (file_exists('app/template/' . $template . '.php')) {
                ob_start();
                include 'app/template/' . $template . '.php';
                $template = ob_get_clean();
                return $template;
            }
        }

        public function init(): void
        {
            $this->router('');

            if ($this->error === true) {
                $this->router('/error', 'error');
            }
        }

        private function router($url = '/', $class = 'index', $method = 'index', $vars = NULL): void
        {
            if ($this->url[1] === 'ajax') {
                $class = 'App\\Components\\' . $this->url[2];
                $method = $this->url[3] . 'Ajax';
                (new $class())->$method();
                $this->error = false;
            } else{
                if($this->url[1] === ''){
                    $url = 'index' ;
                }else{
                    $url = $this->url[1];
                }
                $class = 'App\\Components\\' . $url;
                $vars[] = (new Controller())->init();
                $vars['content'] = (new $class())->index();
                $this->view($vars);
                $this->error = false;
            }
        }

        private function view($vars): void
        {
            $vars = $this->var($vars);
            include_once 'app/public/index.php';
        }

        private function var($vars)
        {
            foreach ($vars as $key => $var) {
                if (is_array($var)) {
                    foreach ($var as $key2 => $var_one) {
                        $data[$key2] = $var_one;
                    }
                } else {
                    $data[$key] = $var;
                }
            }
            return $data;
        }
    }