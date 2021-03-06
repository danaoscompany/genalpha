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

	public function report() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/report', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function report_list() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$category = $this->input->get('category');
			$this->load->view('payroll/report_list', array(
				'adminID' => $adminID,
				'category' => $category
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function run_thr() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/run_thr', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function bpjs_rate() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/bpjs_rate', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function ex_employees() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/ex_employees', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function add_ex_employee() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/add_ex_employee', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function edit_ex_employee() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$id = intval($this->input->post('id'));
			$this->load->view('payroll/edit_ex_employee', array(
				'adminID' => $adminID,
				'ex_employee_id' => $id
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function settings() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/settings', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function settings_account_preferences() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/settings/account_preferences', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function settings_account_preferences_profile_picture() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/settings/account_preferences/profile_picture', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function settings_account_preferences_change_password() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('payroll/settings/account_preferences/change_password', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}
}
