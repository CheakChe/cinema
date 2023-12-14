<?php


    namespace App\Components;


    use App\Core\AbstractController;
    use App\Core\Controller;
    use App\Core\Router;
    use App\Models\ProductModel;

    class Product extends AbstractController
    {

        private $url, $productModel;

        public function __construct()
        {
            Controller::__construct();
            $this->url = explode('/', $_SERVER['REQUEST_URI']);
            $this->productModel = new ProductModel();
        }

        public function index()
        {

            $schedule = $this->productModel->getSchedule(end($this->url));

            return Router::render('/product',
                [
                    'product' => $this->productModel->getProduct($this->url[2]),
                    'schedule' => $schedule,
                ]);
        }

        public function hallsAjax()
        {

            $_POST = json_decode(file_get_contents('php://input'), true);
            $result['status'] = false;

            if ($_POST['time']) {
                $result['content'] = Router::render('/layouts/listHalls', [
                    'halls' => $this->productModel->getHalls($_POST['time'])
                ]);
                $result['status'] = true;
            }

            echo(json_encode($result));
        }

        public function hallAjax()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $result['status'] = false;
            if (!empty($data)) {
                $data['film'] = $this->productModel->getIdFilmWithUrl($data['film']);
                $result['content'] = $this->hallGenerate($data);
                $result['status'] = true;
            }
            echo json_encode($result);
        }

        private function hallGenerate($data)
        {
            $countPlaces = $this->productModel->getCountPlaceInHall($data['hall']);
            $selectedPlaces = $this->productModel->getSelectedPlaceInHall($data, date('Y-m-d'));

            $hall = [];
            $count_free = $countPlaces;

            for ($place = 1; $place <= (int)$countPlaces; $place++) {
                $hall[$place] = [];
                foreach ($selectedPlaces as $key => $selectPlace) {
                    if ((int)$selectPlace['place'] === $place) {
                        $hall[$place]['select'] = true;
                        $count_free--;
                    }
                }
            }
            return Router::render('/layouts/hall', [
                'hall' => $hall,
                'count_free' => $count_free
            ]);
        }

        public function setPlaceAjax()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $result['status'] = false;
            if (!empty($data)) {
                $data['film'] = (int)$this->productModel->getIdFilmWithUrl($data['film']);
                $occupied_place = false;
                foreach ($data['select_place'] as $key => $place) {
                    $occupied_place_number = $this->productModel->checkFreePlace($data, $key, date('Y-m-d'));
                    if ($occupied_place_number > 0) {
                        $occupied_place = true;
                        break;
                    }
                }
                if (!$occupied_place) {

                    $error_setPlace = false;
                    foreach ($data['select_place'] as $key => $place) {
                        $place = $this->productModel->setPlace($data, $_SESSION['user']['id'], $key);
                        if (!$place) {
                            $error_setPlace = true;
                            break;
                        }
                    }
                    if (!$error_setPlace) {
                        $result['status'] = true;
                    } else {
                        $result['error'] = 'Произошла непредвиденная ошибка занятия места';
                    }
                } else {
                    $result['error'] = "Место под номером {$occupied_place_number} уже занято";
                }
                $result['content'] = $this->hallGenerate($data);
            }
            echo json_encode($result);
        }
    }