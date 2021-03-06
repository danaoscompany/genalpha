<?php

class Wallpaper extends CI_Controller {

    public function index() {
        if ($this->session->logged_in == 1) {
            $adminID = $this->session->user_id;
            $this->load->view('wallpaper', array(
                'adminID' => $adminID
            ));
        } else {
            header('Location: http://localhost/admin/login');
        }
    }
}
