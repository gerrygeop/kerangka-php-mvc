<?php

class Auth extends Controller {

    public function index()
    {
        $data['judul'] = 'Login';

        $this->view('templates/header', $data);
        $this->view('auth/login');
        $this->view('templates/footer');
    }

    public function register()
    {
        $data['judul'] = 'Register';

        $this->view('templates/header', $data);
        $this->view('auth/register');
        $this->view('templates/footer');
    }

    public function registerNewUser()
    {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            Flasher::setAlert('Username atau Password tidak boleh kosong', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        if ( $this->model('UserModel')->findUserByUsername($_POST['username']) ) {
            Flasher::setAlert('Username sudah ada', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if ( $this->model('AuthModel')->register($_POST) > 0 ) {
            Flasher::setAlert('Register berhasil silahkan lakukan login', 'success');
            header('Location: ' . BASEURL . '/auth');
            exit;

        } else {
            Flasher::setAlert('Terjadi kesalahan saat register', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }
    }

    public function login()
    {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            Flasher::setAlert('Username atau Password tidak boleh kosong', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;

        } else {
            $loginUser = $this->model('AuthModel')->login($_POST['username'], $_POST['password']);

            if (is_null($loginUser)) {
                Flasher::setAlert('Username atau password salah', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;

            } else {
                $this->createUserSession($loginUser);
                $this->checkLevelUser();
            }
        }
    }

    public function checkLevelUser()
    {
        if ( isset($_SESSION['user_id']) ) {
            if ( $_SESSION['is_admin'] ) {
                header('Location: '. BASEURL .'/home/dashboard');
                exit;
            }
            header('Location: '. BASEURL .'/home');
            exit;
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['is_admin']);
        session_destroy($_SESSION);
        header('Location: '. BASEURL .'/auth');
        exit;
    }
}