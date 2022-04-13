<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi' => $aksi,
            'tipe' => $tipe
        ];
    }

    public static function setAlert($pesan, $tipe)
    {
        $_SESSION['alert'] = [
            'pesan' => $pesan,
            'tipe' => $tipe
        ];
    }

    public static function flash()
    {
        if (isset($_SESSION['flash'])) {
            echo '<div class="alert alert-'. $_SESSION['flash']['tipe'] .' alert-dismissible fade show" role="alert">
                    <strong>Data '. $_SESSION['flash']['pesan'] .'</strong> '. $_SESSION['flash']['aksi'] .'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                
            unset($_SESSION['flash']);
        }
    }

    public static function alert()
    {
        if (isset($_SESSION['alert'])) {
            echo '<div class="alert alert-'. $_SESSION['alert']['tipe'] .' alert-dismissible fade show" role="alert">'
                    . $_SESSION['alert']['pesan'] .
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                
            unset($_SESSION['alert']);
        }
    }
    
}