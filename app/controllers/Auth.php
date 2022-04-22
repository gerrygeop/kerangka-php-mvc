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
                header('Location: '. BASEURL .'/home');
                exit;
                // $this->checkRoleUser();
            }
        }
    }

    private function checkRoleUser()
    {
        if ( isset($_SESSION['user_id']) ) {
            if ( $_SESSION['role'] ) {
                header('Location: '. BASEURL .'/home/dashboard');
                exit;
            }
            header('Location: '. BASEURL .'/home');
            exit;
        }
    }

    private function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }

    public function logout()
    {
        session_destroy($_SESSION);
        header('Location: '. BASEURL .'/auth');
        exit;
    }
}