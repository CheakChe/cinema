<?php


namespace App\Core;

use App\Components\Basic\Basic;

class Router
{
    private $url;

    public function __construct()
    {
        $this->url = explode('/', $_SERVER['REQUEST_URI']);
    }

    function index()
    {
        $this->router('/', 'Hall');

        $this->router('/ajax/hall/place', 'Hall', 'place');
    }

    static function render($template, $var = NULL)
    {
        if (file_exists('app/template/' . $template . '.php')) {
            ob_start();
            include 'app/template/' . $template . '.php';
            $template = ob_get_contents();
            ob_end_clean();
            return $template;
        }
    }

    private function router($url = '/', $class = 'index', $method = 'index', $vars = NULL)
    {
        if ($_SERVER['REQUEST_URI'] == $url) {
            $class = 'App\\Components\\' . $class . '\\' . $class;

            if ($this->url[1] == 'ajax') {
                $class = new $class();
                $class->$method($vars);
            } else {
                $basic = new Basic();
                $basic = $basic->index();
                $class = new $class();
                $class = $class->$method($vars);
                $this->view([$basic, $class]);
            }
        }
    }

    private function view($vars)
    {
        $vars = $this->var($vars);
        include 'app/public/index.php';
    }

    private function var($vars)
    {
        foreach ($vars as $key => $var) {
            foreach ($var as $key2 => $var_one) {
                $data[$key2] = $var_one;
            }
        }
        return $data;
    }
}