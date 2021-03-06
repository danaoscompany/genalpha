<?php

class Pdf extends CI_Controller {

	public function view() {
		if ($this->session->logged_in == 1) {
			$pdfURL = $this->input->post('url');
			$this->load->view('pdf', array(
				'pdfURL' => $pdfURL
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}
}
