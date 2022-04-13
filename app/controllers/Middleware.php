<?php

class Middleware extends Controller {

    public function index()
    {
        $data['judul'] = 'Login';

        $this->view('templates/header', $data);
        $this->view('auth/login');
        $this->view('templates/footer');
    }

    public function notify()
    {
        $data['judul'] = 'Warning';

        $this->view('templates/header', $data);
        $this->view('templates/notify');
        $this->view('templates/footer');
    }

    public function checkout()
    {
        $this->view('templates/404');
    }

}