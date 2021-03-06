<?php

class Employee extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('employee', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function view() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$userID = intval($this->input->post('user_id'));
			$this->load->view('employee/view', array(
				'adminID' => $adminID,
				'userID' => $userID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}
}
