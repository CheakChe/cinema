<?php


namespace App\Core;

use App\Components\Basic\Basic;

class Router
{
    private $url;
    private $db;

    public function __construct($DB)
    {
        $this->db = $DB;
        $this->url = explode('/', $_SERVER['REQUEST_URI']);
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

    function index()
    {
        $this->router('hall', 'Hall', 'ff');

    }

    private function router($url = '/', $class = 'index', $method = 'index', $vars = NULL)
    {
        if ($this->url[1] == $url) {
            $basic = new Basic($this->db);
            $basic = $basic->index();
            $class = 'App\\Components\\' . $class . '\\' . $class;
            $class = new $class($this->db);
            $class = $class->$method($vars);
            $this->view([$basic, $class]);
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