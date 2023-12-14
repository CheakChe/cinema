<?php


    namespace App\Components;


    use App\Core\AbstractController;
    use App\Core\Controller;
    use App\Core\Router;
    use App\Models\CatalogModel;

    class Catalog extends AbstractController
    {
        private $catalogModel;

        public function __construct()
        {
            Controller::__construct();
            $this->catalogModel = new CatalogModel();
        }

        public function index()
        {
            return Router::render('/catalog',
                [
                    'catalog' => $this->catalogModel->getCatalog()
                ]);
        }
    }