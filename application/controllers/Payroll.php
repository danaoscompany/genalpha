<?php

class Payroll extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function update_component() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/update_component', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function add_component() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/add_component', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function edit_component() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$id = intval($this->input->post('id'));
			$this->load->view('payroll/edit_component', array(
				'adminID' => $adminID,
				'id' => $id
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function run() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/run_payroll', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function run_start() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$employees = $this->input->post('employees');
			$year = $this->input->post('year');
			$month = $this->input->post('month');
			$date = $this->input->post('date');
			$this->load->view('payroll/run_payroll_start', array(
				'adminID' => $adminID,
				'employeesData' => $employees,
				'date' => $date,
				'year' => $year,
				'month' => $month
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}
}
