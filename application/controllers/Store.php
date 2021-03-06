<?php

class Store extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('store', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://genalpha.id/admin/login');
		}
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$role = intval($this->db->query("SELECT * FROM `admins` WHERE `id`=" . $adminID)->row_array()['role']);
			if ($role == 1 || $role == 3) {
				$this->load->view('store/add', array(
					'adminID' => $adminID
				));
			} else {
				header('Location: http://genalpha.id/admin/store');
			}
		} else {
			header('Location: http://genalpha.id/admin/login');
		}
	}

	public function edit() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$storeID = intval($this->input->post('id'));
			$role = intval($this->db->query("SELECT * FROM `admins` WHERE `id`=" . $adminID)->row_array()['role']);
			if ($role == 1 || $role == 3) {
				$this->load->view('store/edit', array(
					'adminID' => $adminID,
					'storeID' => $storeID
				));
			} else {
				header('Location: http://genalpha.id/admin/store');
			}
		} else {
			header('Location: http://genalpha.id/admin/login');
		}
	}
}
