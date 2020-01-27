<?php


namespace App\Components\Basic;

use App\Core\Router;

class Basic
{
    protected $db;

    public function __construct($DB)
    {
        $this->db = $DB;
    }

    public function index()
    {

        $data['header'] = Router::render('default/header',
            ['title' => 'My page',
                'styles' => [
                    'style',
                    'reset.min'
                ]
            ]);
        $data['footer'] = Router::render('default/footer',
            ['scripts' => ['main']]);

        return $data;
    }

}