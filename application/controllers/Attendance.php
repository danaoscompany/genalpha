<?php

class Attendance extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('attendance', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://genalpha.id/admin/login');
		}
	}
}
