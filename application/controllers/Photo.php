<?php

class Photo extends CI_Controller {

	public function view() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$url = $this->input->post('url');
			$this->load->view('photo/view', array(
				'adminID' => $adminID,
				'url' => $url
			));
		} else {
			header('Location: http://genalpha.id/admin/login');
		}
	}
}
