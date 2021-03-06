<?php

include 'MailSender.php';
include 'Util.php';

class Employer extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('employer', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function view() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$employerID = intval($this->input->post('employer_id'));
			$this->load->view('employer/view', array(
				'adminID' => $adminID,
				'employerID' => $employerID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}
	
	public function get_workers() {
		$employerID = intval($this->input->post('employer_id'));
		$employees = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID)->result_array();
		for ($i=0; $i<sizeof($employees); $i++) {
			$employee = $employees[$i];
			$users = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employee['user_id'])->result_array();
			if (sizeof($users) > 0) {
				$employees[$i]['user'] = $users[0];
			} else {
				$employees[$i]['user'] = json_encode(array());
			}
			$experiences = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $employees[$i]['user']['id'])->result_array();
			if (sizeof($experiences) > 0) {
				$experience = $experiences[0];
				$employees[$i]['user']['position'] = $experience['position'];
			} else {
				$employees[$i]['user']['position'] = "";
			}
		}
		echo json_encode($employees);
	}
	
	public function delete_attendance_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('attendances');
	}
	
	public function get_applicants() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$applicants = $this->db->query("SELECT * FROM `employees` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID)->result_array();
		for ($i=0; $i<sizeof($applicants); $i++) {
			$applicants[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $applicants[$i]['user_id'])->row_array();
			$applicants[$i]['job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $applicants[$i]['job_id'])->row_array();
			$applicants[$i]['experience'] = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $applicants[$i]['user_id'])->row_array();
		}
		echo json_encode($applicants);
	}
	
	public function get_applicants_by_employer_id() {
		$employerID = intval($this->input->post('employer_id'));
		$jobID = intval($this->input->post('job_id'));
		$applicants = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `job_id`=" . $jobID)->result_array();
		for ($i=0; $i<sizeof($applicants); $i++) {
			$applicants[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $applicants[$i]['user_id'])->row_array();
			$applicants[$i]['job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $applicants[$i]['job_id'])->row_array();
			$applicants[$i]['experience'] = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $applicants[$i]['user_id'])->row_array();
		}
		echo json_encode($applicants);
	}
	
	public function get_employee() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$employerID = intval($this->input->post('employer_id'));
		$employee = $this->db->query("SELECT * FROM `employees` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID . " AND `employer_id`=" . $employerID)->row_array();
		$employee['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employee['user_id'])->row_array();
		$employee['job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $employee['job_id'])->row_array();
		$employee['experience'] = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $employee['user_id'])->row_array();
		echo json_encode($employee);
	}

	public function get_employer_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		echo json_encode($this->db->get('employers')->row_array());
	}
	
	public function get_employees() {
		$employerID = intval($this->input->post('employer_id'));
		$employees = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " GROUP BY `user_id`")->result_array();
		for ($i=0; $i<sizeof($employees); $i++) {
			$employees[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employees[$i]['user_id'])->row_array();
			$employees[$i]['job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $employees[$i]['job_id'])->row_array();
		}
		echo json_encode($employees);
	}

	public function get_resigned_employees() {
		$employerID = intval($this->input->post('employer_id'));
		$employees = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date_out` IS NOT NULL")->result_array();
		for ($i=0; $i<sizeof($employees); $i++) {
			$employees[$i]['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employees[$i]['user_id'])->row_array();
			$employees[$i]['job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $employees[$i]['job_id'])->row_array();
		}
		echo json_encode($employees);
	}

	public function get_ex_employees() {
		$employerID = intval($this->input->post('employer_id'));
		$employees = $this->db->query("SELECT * FROM `ex_employees` WHERE `employer_id`=" . $employerID)->result_array();
		echo json_encode($employees);
	}

	public function get_employee_resume() {
		$userID = intval($this->input->post('user_id'));
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		if ($user == null) {
			echo '';
		} else {
			echo $user['resume'];
		}
	}
	
	public function get_user_by_id() {
		$userID = intval($this->input->post('id'));
		$users = $this->db->get_where('users', array(
			'id' => $userID
		))->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$experiences = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $user['id'])->result_array();
			if (sizeof($experiences) > 0) {
				$experience = $experiences[0];
				$user['position'] = $experience['position'];
			} else {
				$user['position'] = "";
			}
			echo json_encode($user);
		} else {
			echo json_encode(array());
		}
	}
	
	public function update_employee_status() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$employerID = intval($this->input->post('employer_id'));
		$status = $this->input->post('status');
		$lang = $this->input->post('lang');
		$this->db->query("UPDATE `employees` SET `status`='" . $status . "' WHERE `user_id`=" . $userID . " AND `employer_id`=" . $employerID . " AND `job_id`=" . $jobID);
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		$oneSignalPlayerID = $user['onesignal_player_id'];
		if ($lang == 'en') {
			MailSender::sendMail($oneSignalPlayerID, 'Good news!', 'A company has accepted you to become their employees');
		} else if ($lang == 'in') {
			MailSender::sendMail($oneSignalPlayerID, 'Berita bagus!', 'Sebuah perusahaan telah menerimamu menjadi karyawan mereka');
		}
	}
	
	public function add_job() {
		$employerID = intval($this->input->post('employer_id'));
		$categoryID = intval($this->input->post('category_id'));
		$subcategoryID = intval($this->input->post('subcategory_id'));
		$jobTitle = $this->input->post('job_title');
		$companyName = $this->input->post('company_name');
		$workingStart = $this->input->post('working_start');
		$workingEnd = $this->input->post('working_end');
		$specialization = $this->input->post('specialization');
		$workField = $this->input->post('work_field');
		$country = $this->input->post('country');
		$industry = $this->input->post('industry');
		$position = $this->input->post('position');
		$salary = intval($this->input->post('salary'));
		$salaryCurrency = $this->input->post('salary_currency');
		$workDescription = $this->input->post('work_description');
		$documentCount = intval($this->input->post('document_count'));
		$photoCount = intval($this->input->post('photo_count'));
		$documents = json_decode($this->input->post('documents'), true);
		$photos = json_decode($this->input->post('photos'), true);
		$postDate = $this->input->post('post_date');
		$this->db->insert('jobs', array(
			'employer_id' => $employerID,
			'category_id' => $categoryID,
			'subcategory_id' => $subcategoryID,
			'job_title' => $jobTitle,
			'company_name' => $companyName,
			'working_start' => $workingStart,
			'working_end' => $workingEnd,
			'specialization' => $specialization,
			'work_field' => $workField,
			'country' => $country,
			'industry' => $industry,
			'position' => $position,
			'salary' => $salary,
			'salary_currency' => $salaryCurrency,
			'work_description' => $workDescription,
			'post_date' => $postDate
		));
		$jobID = intval($this->db->insert_id());
		for ($i=0; $i<$documentCount; $i++) {
			$config['upload_path']          = './userdata/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = 2147483647;
	        $config['file_name']            = Util::generateUUIDv4() . ".pdf";
	        $this->load->library('upload', $config);
	        if ($this->upload->do_upload('document' . ($i+1))) {
	        	$this->db->insert('job_documents', array(
	        		'job_id' => $jobID,
	        		'path' => $this->upload->data()['file_name'],
	        		'title' => $documents[$i]['title'],
	        		'date' => $documents[$i]['date']
	        	));
	        }
		}
		for ($i=0; $i<$photoCount; $i++) {
			$config['upload_path']          = './userdata/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = 2147483647;
	        $config['file_name']            = Util::generateUUIDv4() . ".pdf";
	        $this->load->library('upload', $config);
	        if ($this->upload->do_upload('photo' . ($i+1))) {
	        	$this->db->insert('job_photos', array(
	        		'job_id' => $jobID,
	        		'path' => $this->upload->data()['file_name'],
	        		'date' => $photos[$i]['date']
	        	));
	        }
		}
	}
	
	public function add_document() {
		$jobID = intval($this->input->post('job_id'));
		$title = $this->input->post('title');
		$date = $this->input->post('date');
		$config['upload_path']          = './userdata/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 2147483647;
        $config['file_name']            = Util::generateUUIDv4() . ".pdf";
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
        	$this->db->insert('job_documents', array(
        		'job_id' => $jobID,
        		'path' => $this->upload->data()['file_name'],
        		'title' => $title,
        		'date' => $date
        	));
        } else {
        	echo json_encode($this->upload->display_errors());
        }
	}
	
	public function get_jobs() {
		$employerID = intval($this->input->post('employer_id'));
		$jobs = $this->db->query("SELECT * FROM `jobs` WHERE `employer_id`=" . $employerID . " ORDER BY `job_title`")->result_array();
		echo json_encode($jobs);
	}
	
	public function delete_job() {
		$jobID = intval($this->input->post('job_id'));
		$documents = $this->db->query("SELECT * FROM `job_documents` WHERE `job_id`=" . $jobID)->result_array();
		$photos = $this->db->query("SELECT * FROM `job_photos` WHERE `job_id`=" . $jobID)->result_array();
		for ($i=0; $i<sizeof($documents); $i++) {
			unlink("userdata/" . $documents[$i]['path']);
		}
		for ($i=0; $i<sizeof($photos); $i++) {
			unlink("userdata/" . $photos[$i]['path']);
		}
		$this->db->where('id', $jobID);
		$this->db->delete('jobs');
	}

	public function get_employee_email() {
		$employeeID = intval($this->input->post('employee_id'));
		$employee = $this->db->query("SELECT * FROM `employees` WHERE `id`=" . $employeeID)->row_array();
		echo $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employee['user_id'])->row_array()['email'];
	}
	
	public function get_payroll_components() {
		$employerID = intval($this->input->post('employer_id'));
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$keyword = $this->input->post('keyword');
		$components = NULL;
		if ($month != -1 && $year != -1) {
			if ($keyword != null && trim($keyword) != "") {
				$components = $this->db->query("SELECT * FROM `payroll_components` WHERE `employer_id`=" . $employerID . " AND MONTH(`effective_date`)=" . $month . " AND YEAR(`effective_date`)=" . $year . " AND (`transaction_id` LIKE '%" . $keyword . "%' OR `transaction_type_id` IN (SELECT `id` FROM `transaction_types` WHERE `name` LIKE '%" . $keyword . "%') OR `component_name_id` IN (SELECT `id` FROM `component_names` WHERE `name` LIKE '%" . $keyword . "%') OR `component_type_id` IN (SELECT `id` FROM `component_types` WHERE `name` LIKE '%" . $keyword . "%') OR `effective_date`='" . $keyword . "') ORDER BY `effective_date` DESC")
				->result_array();
			} else {
				$components = $this->db->query("SELECT * FROM `payroll_components` WHERE `employer_id`=" . $employerID . " AND MONTH(`effective_date`)=" . $month . " AND YEAR(`effective_date`)=" . $year . " ORDER BY `effective_date` DESC")
				->result_array();
			}
		} else {
			if ($keyword != null && trim($keyword) != "") {
				$components = $this->db->query("SELECT * FROM `payroll_components` WHERE `employer_id`=" . $employerID . " AND (`transaction_id` LIKE '%" . $keyword . "%' OR `transaction_type_id` IN (SELECT `id` FROM `transaction_types` WHERE `name` LIKE '%" . $keyword . "%') OR `component_name_id` IN (SELECT `id` FROM `component_names` WHERE `name` LIKE '%" . $keyword . "%') OR `component_type_id` IN (SELECT `id` FROM `component_types` WHERE `name` LIKE '%" . $keyword . "%') OR `effective_date`='" . $keyword . "') ORDER BY `effective_date` DESC")
				->result_array();
			} else {
				$components = $this->db->query("SELECT * FROM `payroll_components` WHERE `employer_id`=" . $employerID . " ORDER BY `effective_date` DESC")
				->result_array();
			}
		}
		for ($i=0; $i<sizeof($components); $i++) {
			$components[$i]['transaction_type'] = $this->db->query("SELECT * FROM `transaction_types` WHERE `id`=" . $components[$i]['transaction_type_id'])->row_array()['name'];
			$components[$i]['component_name'] = $this->db->query("SELECT * FROM `component_names` WHERE `id`=" . $components[$i]['component_name_id'])->row_array()['name'];
			$components[$i]['component_type'] = $this->db->query("SELECT * FROM `component_types` WHERE `id`=" . $components[$i]['component_type_id'])->row_array()['name'];
		}
		echo json_encode($components);
	}
	
	public function get_component_names() {
		echo json_encode($this->db->query("SELECT * FROM `component_names`")->result_array());
	}
	
	public function get_transaction_types() {
		echo json_encode($this->db->query("SELECT * FROM `transaction_types`")->result_array());
	}
	
	public function get_employee_payroll_data() {
		$employerID = intval($this->input->post('employer_id'));
		$componentNameID = intval($this->input->post('component_name_id'));
		$transactionTypeID = intval($this->input->post('transaction_type_id'));
		$data = $this->db->query("SELECT * FROM `payroll_default_data` WHERE `employer_id`=" . $employerID . " AND `component_name_id`=" . $componentNameID . " AND `transaction_type_id`=" . $transactionTypeID)->result_array();
		for ($i=0; $i<sizeof($data); $i++) {
			$employee = $this->db->query("SELECT * FROM `employees` WHERE `id`=" . $data[$i]['employee_id'])->row_array();
			$data[$i]['employee'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employee['user_id'])->row_array();
			$addedData = $this->db->query("SELECT * FROM `payroll_data` WHERE `employer_id`=" . $employerID . " AND `employee_id`=" . $employee['id'] . " AND `component_name_id`=" . $componentNameID . " ORDER BY `date_added` DESC LIMIT 1")->result_array();
			if (sizeof($addedData) > 0) {
				$data[$i]['current_amount'] = $addedData[0]['new_amount'];
				$data[$i]['new_amount'] = $addedData[0]['new_amount'];
			}
		}
		echo json_encode($data);
	}
	
	public function add_payroll_component() {
		$employerID = intval($this->input->post('employer_id'));
		$transactionID = $this->input->post('transaction_id');
		$transactionTypeID = intval($this->input->post('transaction_type_id'));
		$componentNameID = intval($this->input->post('component_name_id'));
		$componentTypeID = intval($this->db->query("SELECT * FROM `component_names` WHERE `id`=" . $componentNameID)->row_array()['component_type_id']);
		$effectiveDate = $this->input->post('effective_date');
		$description = $this->input->post('description');
		$payrollData = json_decode($this->input->post('payroll_data'), true);
		$backpayEnabled = intval($this->input->post('backpay_enabled'));
		$backpayDate = $this->input->post('backpay_date');
		$dateAdded = $this->input->post('date_added');
		$this->db->insert('payroll_components', array(
			'employer_id' => $employerID,
			'transaction_id' => $transactionID,
			'transaction_type_id' => $transactionTypeID,
			'component_name_id' => $componentNameID,
			'component_type_id' => $componentTypeID,
			'description' => $description,
			'transaction_type_id' => $transactionTypeID,
			'effective_date' => $effectiveDate,
			'backpay_enabled' => $backpayEnabled,
			'backpay_date' => $backpayDate
		));
		$payrollComponentID = $this->db->insert_id();
		for ($i=0; $i<sizeof($payrollData); $i++) {
			$payrollDatum = $payrollData[$i];
			$this->db->insert('payroll_data', array(
				'employer_id' => $employerID,
				'employee_id' => intval($payrollDatum['employee_id']),
				'payroll_component_id' => $payrollComponentID,
				'component_name_id' => $componentNameID,
				'current_amount' => doubleval($payrollDatum['current_amount']),
				'new_amount' => doubleval($payrollDatum['new_amount']),
				'payroll_default_data_id' => $payrollDatum['payroll_default_data_id'],
				'date_added' => $dateAdded
			));
		}
	}

	public function update_payroll_component() {
		$payrollComponentID = intval($this->input->post('payroll_component_id'));
		$employerID = intval($this->input->post('employer_id'));
		$transactionID = $this->input->post('transaction_id');
		$transactionTypeID = intval($this->input->post('transaction_type_id'));
		$componentNameID = intval($this->input->post('component_name_id'));
		$componentTypeID = intval($this->db->query("SELECT * FROM `component_names` WHERE `id`=" . $componentNameID)->row_array()['component_type_id']);
		$effectiveDate = $this->input->post('effective_date');
		$description = $this->input->post('description');
		$payrollData = json_decode($this->input->post('payroll_data'), true);
		$backpayEnabled = intval($this->input->post('backpay_enabled'));
		$backpayDate = $this->input->post('backpay_date');
		$dateAdded = $this->input->post('date_added');
		$this->db->where('id', $payrollComponentID);
		$this->db->update('payroll_components', array(
			'employer_id' => $employerID,
			'transaction_id' => $transactionID,
			'transaction_type_id' => $transactionTypeID,
			'component_name_id' => $componentNameID,
			'component_type_id' => $componentTypeID,
			'description' => $description,
			'transaction_type_id' => $transactionTypeID,
			'effective_date' => $effectiveDate,
			'backpay_enabled' => $backpayEnabled,
			'backpay_date' => $backpayDate
		));
		for ($i=0; $i<sizeof($payrollData); $i++) {
			$payrollDatum = $payrollData[$i];
			$this->db->where(array(
				'employer_id' => $employerID,
				'employee_id' => intval($payrollDatum['employee_id']),
				'payroll_component_id' => $payrollComponentID,
				'component_name_id' => $componentNameID,
			));
			$this->db->update('payroll_data', array(
				'new_amount' => doubleval($payrollDatum['new_amount'])
			));
		}
	}
	
	public function update_payroll_component_2() {
		$id = intval($this->input->post('id'));
		$employerID = intval($this->input->post('employer_id'));
		$transactionID = $this->input->post('transaction_id');
		$transactionTypeID = intval($this->input->post('transaction_type_id'));
		$componentNameID = intval($this->input->post('component_name_id'));
		$componentTypeID = intval($this->db->query("SELECT * FROM `component_names` WHERE `id`=" . $componentNameID)->row_array()['component_type_id']);
		$transactionTypeID = intval($this->input->post('transaction_type_id'));
		$effectiveDate = $this->input->post('effective_date');
		$description = $this->input->post('description');
		$payrollData = json_decode($this->input->post('payroll_data'), true);
		$backpayEnabled = intval($this->input->post('backpay_enabled'));
		$backpayDate = $this->input->post('backpay_date');
		$this->db->where('id', $id);
		$this->db->update('payroll_components', array(
			'employer_id' => $employerID,
			'transaction_id' => $transactionID,
			'transaction_type_id' => $transactionTypeID,
			'component_name_id' => $componentNameID,
			'component_type_id' => $componentTypeID,
			'description' => $description,
			'transaction_type_id' => $transactionTypeID,
			'effective_date' => $effectiveDate,
			'backpay_enabled' => $backpayEnabled,
			'backpay_date' => $backpayDate
		));
		$this->db->where('payroll_component_id', $id);
		$this->db->delete('payroll_data');
		for ($i=0; $i<sizeof($payrollData); $i++) {
			$payrollDatum = $payrollData[$i];
			$this->db->insert('payroll_data', array(
				'employer_id' => $employerID,
				'employee_id' => intval($payrollDatum['employee_id']),
				'payroll_component_id' => $id,
				'current_amount' => doubleval($payrollDatum['current_amount']),
				'new_amount' => doubleval($payrollDatum['new_amount']),
				'payroll_default_data_id' => $payrollDatum['payroll_default_data_id']
			));
		}
	}
	
	public function delete_component() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('payroll_components');
	}
	
	public function get_component() {
		$id = intval($this->input->post('id'));
		$component = $this->db->query("SELECT * FROM `payroll_components` WHERE `id`=" . $id)->row_array();
		$component['component_name'] = $this->db->query("SELECT * FROM `component_names` WHERE `id`=" . $component['component_name_id'])
			->row_array()['name'];
		$component['transaction_type'] = $this->db->query("SELECT * FROM `transaction_types` WHERE `id`=" . $component['transaction_type_id'])
			->row_array()['name'];
		$component['payroll_data'] = $this->db->query("SELECT * FROM `payroll_data` WHERE `payroll_component_id`=" . $id)->result_array();
		for ($i=0; $i<sizeof($component['payroll_data']); $i++) {
			$component['payroll_data'][$i]['employee'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $component['payroll_data'][$i]['employee_id'])->row_array();
		}
		echo json_encode($component);
	}
	
	public function upload_payroll_data() {
		$employerID = intval($this->input->post('employer_id'));
		$payrollComponentID = intval($this->input->post('payroll_component_id'));
		$payrollData = json_decode($this->input->post('payroll_data'), true);
		$description = $this->input->post('description');
		$this->db->query("DELETE FROM `payroll_data` WHERE `payroll_component_id`=" . $payrollComponentID);
		for ($i=0; $i<sizeof($payrollData); $i++) {
			$payrollDatum = $payrollData[$i];
			$payrollDefaultData = $this->db->query("SELECT * FROM `payroll_default_data` WHERE `employer_id`=" . $employerID . " AND `employee_id`=" . intval($payrollDatum['employee_id']))->row_array();
			$payrollDefaultDataID = 0;
			if ($payrollDefaultData != NULL) {
				$payrollDefaultDataID = intval($payrollDefaultData['id']);
			}
			$this->db->insert('payroll_data', array(
				'employer_id' => $employerID,
				'employee_id' => intval($payrollDatum['employee_id']),
				'payroll_component_id' => $payrollComponentID,
				'payroll_default_data_id' => $payrollDefaultDataID,
				'current_amount' => intval($payrollDatum['current_amount']),
				'new_amount' => intval($payrollDatum['new_amount'])
			));
		}
		if ($description != NULL) {
			$this->db->where('id', $payrollComponentID);
			$this->db->update('payroll_components', array(
				'description' => $description
			));
		}
	}
	
	public function add_payroll_employee_data() {
		$employerID = intval($this->input->post('employer_id'));
		$payrollComponentID = intval($this->input->post('payroll_component_id'));
		$employeeIDs = json_decode($this->input->post('employee_ids'), true);
		$newAmount = intval($this->input->post('new_amount'));
		for ($i=0; $i<sizeof($employeeIDs); $i++) {
			$this->db->insert('payroll_default_data', array(
				'employer_id' => $employerID,
				'payroll_component_id' => $payrollComponentID,
				'employee_id' => $employeeIDs[$i],
				'current_amount' => 0,
				'new_amount' => $newAmount
			));
		}
	}
	
	private function diff_days($date1, $date2) {
		if (strpos($date1, ' ') !== false) {
			$date1 = substr($date1, 0, strpos($date1, ' '));
		}
		if (strpos($date2, ' ') !== false) {
			$date2 = substr($date2, 0, strpos($date2, ' '));
		}
		$date1 = new DateTime($date1);
		$date2 = new DateTime($date2);
		return intval($date2->diff($date1)->format('%a'));
	}
	
	public function get_min_active_days() {
		return intval($this->db->get('settings')->row_array()['min_inactive_days']);
	}
	
	public function get_active_staffs() {
		$employerID = intval($this->input->post('employer_id'));
		$currentDate = $this->input->post('current_date');
		$activeStaffData = [];
		$minInactiveDays = $this->get_min_active_days();
		$employees = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID)->result_array();
		for ($k=0; $k<5; $k++) {
			$activeStaffDatum = [];
			for ($i=0; $i<sizeof($employees); $i++) {
				$employee = $employees[$i];
				$attendances = $this->db->query("SELECT * FROM `attendances` WHERE `user_id`=" . $employee['user_id'] . " AND YEAR(`date`)=YEAR('" . $currentDate . "') AND MONTH(`date`)=MONTH('" . $currentDate . "' - INTERVAL " . $k . " MONTH) AND `date`<='" . $currentDate . "' ORDER BY `date` DESC LIMIT 31")->result_array();
				if (sizeof($attendances) > 0) {
					$totalAbsence = 0; //total tidak absen
					if ($k == 0) {
						if (sizeof($attendances) > 0) {
							$diffDays = $this->diff_days($currentDate, $attendances[0]['date']);
								if ($diffDays > 0) {
								$diffDays--;
							}
							$totalAbsence += $diffDays;
						}
					}
					for ($j=0; $j<sizeof($attendances)-1; $j++) {
						$diffDays = $this->diff_days($attendances[$j]['date'], $attendances[$j+1]['date']);
						if ($diffDays > 0) {
							$diffDays--;
						}
						$totalAbsence += $diffDays;
					}
					//echo "Total absence: " . $totalAbsence . "<br/>";
					if ($totalAbsence < $minInactiveDays) {
						array_push($activeStaffDatum, array('employee_id' => intval($employee['user_id'])));
					}
				}
			}
			$monthName = "";
			$dt = new DateTime($currentDate);
			if ($k == 0) {
				$monthName = $dt->format('M');
			} else if ($k == 1) {
				$dt->modify('-1 month');
				$monthName = $dt->format('M');
			} else if ($k == 2) {
				$dt->modify('-2 month');
				$monthName = $dt->format('M');
			} else if ($k == 3) {
				$dt->modify('-3 month');
				$monthName = $dt->format('M');
			} else if ($k == 4) {
				$dt->modify('-4 month');
				$monthName = $dt->format('M');
			}
			$monthName = strtolower($monthName);
			$activeStaffData[$monthName] = $activeStaffDatum;
		}
		header('Content-Type: application/json');
		echo json_encode($activeStaffData);
	}
	
	public function get_education_levels() {
		$employerID = intval($this->input->post('employer_id'));
		$educationLevels = [];
		$educationLevels['smu'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `educations` WHERE `qualification`='smu')")->num_rows();
		$educationLevels['d3'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `educations` WHERE `qualification`='d3')")->num_rows();
		$educationLevels['s1'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `educations` WHERE `qualification`='s1')")->num_rows();
		$educationLevels['s2'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `educations` WHERE `qualification`='s2')")->num_rows();
		$educationLevels['s3'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `educations` WHERE `qualification`='s3')")->num_rows();
		header('Content-Type: application/json');
		echo json_encode($educationLevels);
	}
	
	public function get_employment_status() {
		$employerID = intval($this->input->post('employer_id'));
		$employmentStatus = [];
		$employmentStatus['permanent'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `type`='permanent'")
			->num_rows();
		$employmentStatus['contract'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `type`='contract'")
			->num_rows();
		echo json_encode($employmentStatus);
	}
	
	public function get_religions() {
		$employerID = intval($this->input->post('employer_id'));
		$religions = [];
		$religions['islam'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `religions` WHERE `religion`='islam')")->num_rows();
		$religions['kristen'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `religions` WHERE `religion`='kristen')")->num_rows();
		$religions['hindu'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `religions` WHERE `religion`='hindu')")->num_rows();
		$religions['buddha'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `religions` WHERE `religion`='buddha')")->num_rows();
		$religions['konghucu'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `religions` WHERE `religion`='konghucu')")->num_rows();
		echo json_encode($religions);
	}
	
	public function get_genders() {
		$employerID = intval($this->input->post('employer_id'));
		$genders = [];
		$genders['male'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `id` FROM `users` WHERE `gender`='male')")->num_rows();
		$genders['female'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `id` FROM `users` WHERE `gender`='female')")->num_rows();
		echo json_encode($genders);
	}
	
	public function get_job_levels() {
		$employerID = intval($this->input->post('employer_id'));
		$jobLevels = [];
		$jobLevels['ceo'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `experiences` WHERE `position`='CEO')")->num_rows();
		$jobLevels['manager'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `experiences` WHERE `position`='Manager')")->num_rows();
		$jobLevels['supervisor'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `experiences` WHERE `position`='Supervisor')")->num_rows();
		$jobLevels['staff'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `experiences` WHERE `position`='Staff')")->num_rows();
		$jobLevels['non_staff'] = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `user_id` IN (SELECT `user_id` FROM `experiences` WHERE `position`='Non-Staff')")->num_rows();
		echo json_encode($jobLevels);
	}
	
	public function get_service_lengths() {
		$employerID = intval($this->input->post('employer_id'));
		$currentDate = $this->input->post('current_date');
		$serviceLengths = [];
		array_push($serviceLengths, $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date`>=DATE_SUB('" . $currentDate . "', INTERVAL 1 YEAR)")->num_rows());
		array_push($serviceLengths, $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date`<DATE_SUB('" . $currentDate . "', INTERVAL 1 YEAR) AND `date`>=DATE_SUB('" . $currentDate . "', INTERVAL 3 YEAR)")->num_rows());
		array_push($serviceLengths, $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date`<DATE_SUB('" . $currentDate . "', INTERVAL 3 YEAR) AND `date`>=DATE_SUB('" . $currentDate . "', INTERVAL 5 YEAR)")->num_rows());
		array_push($serviceLengths, $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date`<DATE_SUB('" . $currentDate . "', INTERVAL 5 YEAR) AND `date`>=DATE_SUB('" . $currentDate . "', INTERVAL 10 YEAR)")->num_rows());
		echo json_encode($serviceLengths);
	}
	
	public function get_monthly_turnover() {
		$employerID = intval($this->input->post('employer_id'));
		$prevMonthEndDate = $this->input->post('prev_month_end_date');
		$currentMonthStartDate = $this->input->post('current_month_start_date');
		$turnovers = [];
		$monthNames = [
			"jan", "feb", "mar", "apr", "mei", "jun", "jul", "agt", "sept", "okt", "nov", "des"
		];
		for ($i=0; $i<5; $i++) {
			//echo "=========================<br/>";
			//echo "PREV DATE: " . $prevMonthEndDate . "<br/>";
			//echo "CURRENT DATE: " . $currentMonthStartDate . "<br/>";
			$dt = new DateTime($prevMonthEndDate);
			$month = intval($dt->format('m'));
			$year = intval($dt->format('y'));
			//echo "SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date`<'" . $prevMonthEndDate . "' AND (`date_out` IS NULL OR `date_out`>'" . $prevMonthEndDate . "')" . "<br/>";
			$prevMonthEmployees = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date`<'" . $prevMonthEndDate . "' AND (`date_out` IS NULL OR `date_out`>'" . $prevMonthEndDate . "')")->num_rows();
			//echo "Prev month employees: " . $prevMonthEmployees . "<br/>";
			$dt = new DateTime($currentMonthStartDate);
			$month = intval($dt->format('m'));
			$year = intval($dt->format('y'));
			$currentMonthEmployees = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date`<'" . $currentMonthStartDate . "' AND (`date_out` IS NULL OR `date_out`>'" . $currentMonthStartDate . "')")->num_rows();
			//echo "Current month employees: " . $currentMonthEmployees . "<br/>";
			$prevMonth = intval(substr($prevMonthEndDate, 5, 2));
			$prevYear = intval(substr($prevMonthEndDate, 0, 4));
			$prevMonthEmployeesOut = $this->db->query("SELECT * FROM `employees` WHERE `employer_id`=" . $employerID . " AND `date_out`<'" . $prevMonthEndDate . "' AND MONTH(`date_out`)=" . $prevMonth . " AND YEAR(`date_out`)=" . $prevYear)->num_rows();
			//echo "Prev month employees out: " . $prevMonthEmployeesOut . "<br/>";
			$employeeChanges = ($prevMonthEmployees+$currentMonthEmployees)/2;
			$turnoverValue = 0;
			if ($employeeChanges > 0) {
				$turnoverValue = $prevMonthEmployeesOut/($employeeChanges)*100;
			}
			$turnovers[$monthNames[$month-1]] = $turnoverValue;
			$dt = new DateTime($prevMonthEndDate);
			$dt->modify("-1 month");
			$prevMonthEndDate = $dt->format('Y:m:d H:i:s');
			$dt = new DateTime($currentMonthStartDate);
			$dt->modify("-1 month");
			$currentMonthStartDate = $dt->format('Y:m:d H:i:s');
		}
		echo json_encode($turnovers);
	}

	public function get_employees_from_ids() {
		$employeeIDs = json_decode($this->input->post('ids'));
		$employees = array();
		for ($i=0; $i<sizeof($employeeIDs); $i++) {
			$id = $employeeIDs[$i];
			$employee = $this->db->query("SELECT * FROM `employees` WHERE `id`=" . $id)->row_array();
			$employee['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employee['user_id'])->row_array();
			$employee['job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $employee['job_id'])->row_array();
			$employee['experience'] = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $employee['user_id'])->row_array();
			array_push($employees, $employee);
		}
		echo json_encode($employees);
	}

	private function get_full_month_name($month) {
		if ($month == 0) {
			return "Januari";
		} else if ($month == 1) {
			return "Februari";
		} else if ($month == 2) {
			return "Maret";
		} else if ($month == 3) {
			return "April";
		} else if ($month == 4) {
			return "Mei";
		} else if ($month == 5) {
			return "Juni";
		} else if ($month == 6) {
			return "Juli";
		} else if ($month == 7) {
			return "Agustus";
		} else if ($month == 8) {
			return "September";
		} else if ($month == 9) {
			return "Oktober";
		} else if ($month == 10) {
			return "November";
		} else if ($month == 11) {
			return "Desember";
		}
		return "";
	}

	public function send_salary_slip() {
		$employeeID = intval($this->input->post('employee_id'));
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		if (strlen($month) < 2) {
			$month = "0" . $month;
		}
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employeeID)->row_array();
		$pdfFileName = Util::generateUUIDv4() . ".pdf";
		file_put_contents("userdata/" . $pdfFileName, base64_decode($this->input->post('salary_slip')));
		MailSender::sendMailWithAttachments('danaoscompany@gmail.com',
			'Slip Gaji Bulan ' . $month . '-' . $year,
			'Terlampir slip gaji bulan ' . $month . '-' . $year,
			array(
				'userdata/' . $pdfFileName
			));
		//echo $pdfFileName;
	}

	public function get_total_days_working() {
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$daysCount = intval($this->input->post('days_count')); // total days in month
		$totalDaysWorking = 0;
		for ($i=0; $i<$daysCount; $i++) {
			$date = new DateTime();
			$date->setDate($year, $month, $i+1);
			$come = $this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='come'")->row_array();
			$leave = $this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='leave'")->row_array();
			if ($come != NULL && $leave != NULL) {
				$totalDaysWorking++;
			}
		}
		echo $totalDaysWorking;
	}

	public function get_total_days_sick() {
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$daysCount = intval($this->input->post('days_count')); // total days in month
		$totalDaysSick = 0;
		for ($i=0; $i<$daysCount; $i++) {
			$date = new DateTime();
			$date->setDate($year, $month, $i+1);
			$sick = $this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='sick'")->row_array();
			if ($sick != NULL) {
				$totalDaysSick++;
			}
		}
		echo $totalDaysSick;
	}

	public function get_total_days_sick_with_skd() {
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$daysCount = intval($this->input->post('days_count')); // total days in month
		$totalDaysSick = 0;
		for ($i=0; $i<$daysCount; $i++) {
			$date = new DateTime();
			$date->setDate($year, $month, $i+1);
			$sick = $this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='sick_with_skd'")->row_array();
			if ($sick != NULL) {
				$totalDaysSick++;
			}
		}
		echo $totalDaysSick;
	}

	public function get_total_days_asking_permission() {
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$daysCount = intval($this->input->post('days_count')); // total days in month
		$totalDaysAskingPermission = 0;
		for ($i=0; $i<$daysCount; $i++) {
			$date = new DateTime();
			$date->setDate($year, $month, $i+1);
			$in = intval($this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='in'")->num_rows());
			$out = intval($this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='out'")->num_rows());
			if ($in > 0 && $out > 0 && $in == $out) {
				$totalDaysAskingPermission++;
			}
		}
		echo $totalDaysAskingPermission;
	}

	public function get_total_days_asking_permission_2() {
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$daysCount = intval($this->input->post('days_count')); // total days in month
		$totalDaysAskingPermission = 0;
		for ($i=0; $i<$daysCount; $i++) {
			$date = new DateTime();
			$date->setDate($year, $month, $i+1);
			$askingPermission = $this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='permission_2'")->row_array();
			if ($askingPermission != NULL) {
				$totalDaysAskingPermission++;
			}
		}
		echo $totalDaysAskingPermission;
	}

	public function get_total_days_overtime() {
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$daysCount = intval($this->input->post('days_count')); // total days in month
		$totalDaysOvertime = 0;
		for ($i=0; $i<$daysCount; $i++) {
			$date = new DateTime();
			$date->setDate($year, $month, $i+1);
			$overtime = $this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='overtime'")->row_array();
			if ($overtime != NULL) {
				$totalDaysOvertime++;
			}
		}
		echo $totalDaysOvertime;
	}

	public function get_total_days_cuti() {
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$daysCount = intval($this->input->post('days_count')); // total days in month
		$totalDaysCuti = 0;
		for ($i=0; $i<$daysCount; $i++) {
			$date = new DateTime();
			$date->setDate($year, $month, $i+1);
			$cuti = $this->db->query("SELECT * FROM `attendances` WHERE DATE(`date`)='" . $date->format('Y-m-d') . "' AND `type`='cuti'")->row_array();
			if ($cuti != NULL) {
				$totalDaysCuti++;
			}
		}
		echo $totalDaysCuti;
	}
	
	public function update_fcm_id() {
		$userID = intval($this->input->post('user_id'));
		$fcmID = $this->input->post('fcm_id');
		$this->db->query("UPDATE `employers` SET `fcm_id`='" . $fcmID . "' WHERE `id`=" . $userID);
	}
	
	public function get_chats() {
		$employerID = intval($this->input->post('employer_id'));
		$chats = $this->db->query("SELECT * FROM `chats` WHERE (`user_1`=" . $employerID . " AND `user_1_type`='employer') OR (`user_2`=" . $employerID . " AND `user_2_type`='employer')")->result_array();
		for ($i=0; $i<sizeof($chats); $i++) {
			$user1Type = $chats[$i]['user_1_type'];
			$user2Type = $chats[$i]['user_2_type'];
			if ($user1Type == 'employer') {
				$chats[$i]['opponent'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chats[$i]['user_2'])->row_array();
			} else if ($user2Type == 'employer') {
				$chats[$i]['opponent'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $chats[$i]['user_1'])->row_array();
			}
		}
		echo json_encode($chats);
	}

	public function get_reports() {
		$employerID = intval($this->input->post('employer_id'));
		$category = $this->input->post('category');
		echo json_encode($this->db->query("SELECT * FROM `reports` WHERE `employer_id`=" . $employerID . " AND `category`='" . $category . "'")->result_array());
	}

	public function add_ex_employee() {
		$employerID = intval($this->input->post('employer_id'));
		$description = $this->input->post('description');
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$numEmployees = intval($this->input->post('num_employees'));
		$taxable = intval($this->input->post('taxable'));
		$employees = json_decode($this->input->post('employees'), true);
		$amounts = json_decode($this->input->post('amounts'), true);
		$transactionID = "" . $year . sprintf('%02d', $month);
		$exEmployees = $this->db->query("SELECT * FROM `ex_employees` WHERE `transaction_id` LIKE '" . $transactionID . "%'")->result_array();
		if (sizeof($exEmployees) > 0) {
			$exEmployee = $exEmployees[0];
			$lastTransactionID = $exEmployee['transaction_id'];
			$lastTransactionID = str_replace($transactionID, '', $lastTransactionID);
			$lastTransactionID = intval($lastTransactionID)+1;
			$transactionID = $transactionID . sprintf('%03d', $lastTransactionID);
		} else {
			$transactionID .= "001";
		}
		$this->db->insert('ex_employees', array(
			'transaction_id' => $transactionID,
			'employer_id' => $employerID,
			'description' => $description,
			'month' => $month,
			'year' => $year,
			'num_employees' => $numEmployees,
			'taxable' => $taxable
		));
		$lastExEmployeeID = intval($this->db->insert_id());
		for ($i=0; $i<sizeof($employees); $i++) {
			$employee = $employees[$i];
			$this->db->insert('ex_employee_allowances', array(
				'ex_employee_id' => $lastExEmployeeID,
				'employee_id' => intval($employee['id']),
				'amount' => doubleval($amounts[$i])
			));
		}
	}

	public function update_ex_employee() {
		$id = intval($this->input->post('id'));
		$employerID = intval($this->input->post('employer_id'));
		$this->db->query("DELETE FROM `ex_employee_allowances` WHERE `ex_employee_id`=" . $id);
		$this->db->query("DELETE FROM `ex_employees` WHERE `id`=" . $id);
		$description = $this->input->post('description');
		$month = intval($this->input->post('month'));
		$year = intval($this->input->post('year'));
		$numEmployees = intval($this->input->post('num_employees'));
		$taxable = intval($this->input->post('taxable'));
		$employees = json_decode($this->input->post('employees'), true);
		$amounts = json_decode($this->input->post('amounts'), true);
		$transactionID = "" . $year . sprintf('%02d', $month);
		$exEmployees = $this->db->query("SELECT * FROM `ex_employees` WHERE `transaction_id` LIKE '" . $transactionID . "%'")->result_array();
		if (sizeof($exEmployees) > 0) {
			$exEmployee = $exEmployees[0];
			$lastTransactionID = $exEmployee['transaction_id'];
			$lastTransactionID = str_replace($transactionID, '', $lastTransactionID);
			$lastTransactionID = intval($lastTransactionID)+1;
			$transactionID = $transactionID . sprintf('%03d', $lastTransactionID);
		} else {
			$transactionID .= "001";
		}
		$this->db->insert('ex_employees', array(
			'transaction_id' => $transactionID,
			'employer_id' => $employerID,
			'description' => $description,
			'month' => $month,
			'year' => $year,
			'num_employees' => $numEmployees,
			'taxable' => $taxable
		));
		$lastExEmployeeID = intval($this->db->insert_id());
		for ($i=0; $i<sizeof($employees); $i++) {
			$employee = $employees[$i];
			$this->db->insert('ex_employee_allowances', array(
				'ex_employee_id' => $lastExEmployeeID,
				'employee_id' => intval($employee['id']),
				'amount' => doubleval($amounts[$i])
			));
		}
	}

	public function delete_ex_employee() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM `ex_employee_allowances` WHERE `ex_employee_id`=" . $id);
		$this->db->query("DELETE FROM `ex_employees` WHERE `id`=" . $id);
	}

	public function get_ex_employee_by_id() {
		$id = intval($this->input->post('id'));
		$exEmployee = $this->db->query("SELECT * FROM `ex_employees` WHERE `id`=" . $id)->row_array();
		$employees = [];
		$exEmployeeAllowances = $this->db->query("SELECT * FROM `ex_employee_allowances` WHERE `ex_employee_id`=" . $id)->result_array();
		for ($i=0; $i<sizeof($exEmployeeAllowances); $i++) {
			$exEmployeeAllowance = $exEmployeeAllowances[$i];
			$employee = $this->db->query("SELECT * FROM `employees` WHERE `id`=" . $exEmployeeAllowance['employee_id'])->row_array();
			$employee['user'] = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $employee['user_id'])->row_array();
			array_push($employees, $employee);
		}
		$exEmployee['employees'] = $employees;
		$exEmployee['ex_employee_allowances'] = $exEmployeeAllowances;
		echo json_encode($exEmployee);
	}

	public function update_profile_picture() {
		$id = intval($this->input->post('id'));
		$config['upload_path']          = './userdata/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 2147483647;
		$config['file_name']            = Util::generateUUIDv4();
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')) {
			$this->db->where('id', $id);
			$this->db->update('employers', array(
				'profile_picture' => $this->upload->data()['file_name']
			));
		} else {
			echo json_encode($this->upload->display_errors());
		}
	}

	public function update_password() {
		$id = intval($this->input->post('id'));
		$oldPassword = $this->input->post('old_password');
		$newPassword = $this->input->post('new_password');
		$user = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . $id)->row_array();
		if ($user['password'] != $oldPassword) {
			echo json_encode(array(
				'response_code' => -1
			));
		} else {
			$this->db->query("UPDATE `employers` SET `password`='" . $newPassword . "' WHERE `id`=" . $id);
			echo json_encode(array(
				'response_code' => 1
			));
		}
	}
	
	public function get_offshore_jobs() {
		$employerID = intval($this->input->post('employer_id'));
		$jobs = $this->db->query("SELECT * FROM `jobs` WHERE `employer_id`=" . $employerID . " AND `is_offshore`=1 ORDER BY `job_title`")->result_array();
		echo json_encode($jobs);
	}
}
