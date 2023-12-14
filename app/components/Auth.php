<?php


    namespace App\Components;


    use App\Core\AbstractController;
    use App\Core\Controller;
    use App\Core\Router;
    use App\Models\UserModel;

    class Auth extends AbstractController
    {

        private $userModel, $url;

        public function __construct()
        {
            Controller::__construct();
            $this->userModel = new UserModel();
            $this->url = explode('/', $_SERVER['REQUEST_URI']);
        }

        public function index()
        {
            if ($this->url[2] === 'logout' && isset($_SESSION['user'])) {
                $this->logout();
            }

            if (isset($_SESSION['user'])) {
                header('Location: /');
            }
            return Router::render('/auth');
        }

        public function enterAjax()
        {
            if ($user = $this->userModel->userExists($_POST['login'])) {
                if (password_verify($_POST['password'], $user['password'])) {
                    $_SESSION['user'] = $user;
                    $this->userModel->userOnline($user['id']);
                    $result['message'] = 'Вы успешно авторизировались.';
                } else {
                    $result['message'] = 'Не верный пароль.';
                }
            } else {
                $result['message'] = 'Пользователь не существует';
            }
            echo json_encode($result);
        }

        public function registrationAjax()
        {
            if (!$this->userModel->userExists($_POST['login'])) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $this->userModel->addUser($_POST['login'], $password, $_POST['phone']);
                $result['message'] = 'Аккаунт создан';
            } else {
                $result['message'] = 'Данные заняты или введены не правильно';
            }
            echo json_encode($result);
        }

        public function logout(): void
        {
            $this->userModel->logout($_SESSION['user']);
            unset($_SESSION['user']);
            header('Location: /');
        }
    }