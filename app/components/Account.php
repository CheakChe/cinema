<?php


    namespace App\Components;


    use App\Core\AbstractController;
    use App\Core\Controller;
    use App\Core\Router;
    use App\Models\AccountModel;

    class Account extends AbstractController
    {
        private $accountModel;

        public function __construct()
        {
            Controller::__construct();
            $this->accountModel = new AccountModel();

        }

        public function index()
        {
            $history = $this->accountModel->getAccountHistory($_SESSION['user']['id']);
            foreach ($history as $key => &$item) {
                $place = $this->accountModel->getAccountPlace(
                    $_SESSION['user']['id'],
                    $item['film_id'],
                    $item['time_id'],
                    $item['hall_id'],
                    $item['date']
                );
                $item['price'] = $this->accountModel->getAccountPrice(
                    $_SESSION['user']['id'],
                    $item['film_id'],
                    $item['time_id'],
                    $item['hall_id'],
                    $item['date']
                );
                foreach ($place as $placeKey => $placeOne) {
                    if (empty($item['place'])) {
                        $item['place'] = $placeOne['place'];
                    } else {
                        $item['place'] .= ', ' . $placeOne['place'];
                    }
                }
            }

            return Router::render('/account',
                [
                    'account' => $this->accountModel->getAccountInfo($_SESSION['user']['id']),
                    'history' => $history
                ]);
        }
    }

    {
    }