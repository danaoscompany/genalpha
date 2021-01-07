<?php

class Job extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('job', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function view() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$jobID = intval($this->input->post('job_id'));
			$this->load->view('job/view', array(
				'adminID' => $adminID,
				'jobID' => $jobID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}
}
