<?php

include 'MailSender.php';
include 'Util.php';
include 'FCM.php';

class User extends CI_Controller {

	public function index() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('user', array(
				'adminID' => $adminID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}

	public function add() {
		if ($this->session->logged_in == 1) {
			$adminID = $this->session->user_id;
			$this->load->view('user/add', array(
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
			$this->load->view('user/view', array(
				'adminID' => $adminID,
				'userID' => $userID
			));
		} else {
			header('Location: http://localhost/admin/login');
		}
	}
	
	public function login() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			$experiences = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $user['id'])->result_array();
			if (sizeof($experiences) > 0) {
				$experience = $experiences[0];
				$user['position'] = $experience['position'];
			} else {
				$user['position'] = "";
			}
			$user['role'] = "worker";
			echo json_encode($user);
		} else {
			$users = $this->db->query("SELECT * FROM `employers` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
			if (sizeof($users) > 0) {
				$user = $users[0];
				$user['response_code'] = 1;
				$user['role'] = "employer";
				echo json_encode($user);
			} else {
				echo json_encode(array(
					'response_code' => -1
				));
			}
		}
	}
	
	public function login_as_worker() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			$experiences = $this->db->query("SELECT * FROM `experiences` WHERE `user_id`=" . $user['id'])->result_array();
			if (sizeof($experiences) > 0) {
				$experience = $experiences[0];
				$user['position'] = $experience['position'];
			} else {
				$user['position'] = "";
			}
			echo json_encode($user);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function login_as_employer() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$employers = $this->db->query("SELECT * FROM `employers` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($employers) > 0) {
			$employer = $employers[0];
			$employer['response_code'] = 1;
			echo json_encode($employer);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function signup_as_employer() {
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$password = $this->input->post('password');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
		} else {
			$users = $this->db->query("SELECT * FROM `employers` WHERE `email`='" . $email . "'")->result_array();
			if (sizeof($users) > 0) {
				echo json_encode(array(
					'response_code' => -1
				));
			} else {
				$users = $this->db->query("SELECT * FROM `users` WHERE `phone`='" . $phone . "'")->result_array();
				if (sizeof($users) > 0) {
					echo json_encode(array(
						'response_code' => -2
					));
				} else {
					$users = $this->db->query("SELECT * FROM `employers` WHERE `phone`='" . $phone . "'")->result_array();
					if (sizeof($users) > 0) {
						echo json_encode(array(
							'response_code' => -2
						));
					} else {
						$this->db->insert('employers', array(
							'first_name' => $firstName,
							'last_name' => $lastName,
							'email' => $email,
							'phone' => $phone,
							'password' => $password
							));
						$userID = intval($this->db->insert_id());
						echo json_encode(array(
							'response_code' => 1,
							'user_id' => $userID
						));
					}
				}
			}
		}
	}
	
	public function signup_as_worker() {
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$password = $this->input->post('password');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->result_array();
		if (sizeof($users) > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
		} else {
			$users = $this->db->query("SELECT * FROM `employers` WHERE `email`='" . $email . "'")->result_array();
			if (sizeof($users) > 0) {
				echo json_encode(array(
					'response_code' => -1
				));
			} else {
				$users = $this->db->query("SELECT * FROM `users` WHERE `phone`='" . $phone . "'")->result_array();
				if (sizeof($users) > 0) {
					echo json_encode(array(
						'response_code' => -2
					));
				} else {
					$users = $this->db->query("SELECT * FROM `employers` WHERE `phone`='" . $phone . "'")->result_array();
					if (sizeof($users) > 0) {
						echo json_encode(array(
							'response_code' => -2
						));
					} else {
						$this->db->insert('users', array(
							'first_name' => $firstName,
							'last_name' => $lastName,
							'email' => $email,
							'phone' => $phone,
							'password' => $password
							));
						$userID = intval($this->db->insert_id());
						echo json_encode(array(
							'response_code' => 1,
							'user_id' => $userID
						));
					}
				}
			}
		}
	}
	
	public function send_email() {
		$to = $this->input->post('to');
		$subject = $this->input->post('subject');
		$content = $this->input->post('content');
		MailSender::sendMail($to, $subject, $content);
	}
	
	public function send_verification_email_to_worker() {
		$userID = intval($this->input->post('user_id'));
		$verificationCode = $this->input->post('verification_code');
		$lang = $this->input->post('lang');
		$content = '';
		$title = '';
		if ($lang == 'en') {
			$title = "Kinerjaku.id - " . $verificationCode . " is your verification code";
			$content = file_get_contents('systemdata/email_templates/verification_en.html');
		} else if ($lang == 'in') {
			$title = "Kinerjaku.id - " . $verificationCode . " adalah kode verifikasi Anda";
			$content = file_get_contents('systemdata/email_templates/verification_in.html');
		}
		$displayedVerificationCode = $verificationCode[0] . " " . $verificationCode[1] . " " . $verificationCode[2] . " " . $verificationCode[3] .
			" " . $verificationCode[4] . " " . $verificationCode[5];
		$content = str_replace("[verificationCode]", $displayedVerificationCode, $content);
		$user = $this->db->get_where('users', array('id' => $userID))->row_array();
		$to = $user['email'];
		MailSender::sendMail($to, $title, $content);
	}
	
	public function send_verification_email_to_employer() {
		$userID = intval($this->input->post('user_id'));
		$verificationCode = $this->input->post('verification_code');
		$lang = $this->input->post('lang');
		$content = '';
		$title = '';
		if ($lang == 'en') {
			$title = "Kinerjaku.id - " . $verificationCode . " is your verification code";
			$content = file_get_contents('systemdata/email_templates/verification_en.html');
		} else if ($lang == 'in') {
			$title = "Kinerjaku.id - " . $verificationCode . " adalah kode verifikasi Anda";
			$content = file_get_contents('systemdata/email_templates/verification_in.html');
		}
		$displayedVerificationCode = $verificationCode[0] . " " . $verificationCode[1] . " " . $verificationCode[2] . " " . $verificationCode[3] .
			" " . $verificationCode[4] . " " . $verificationCode[5];
		$content = str_replace("[verificationCode]", $displayedVerificationCode, $content);
		$employer = $this->db->get_where('employers', array('id' => $userID))->row_array();
		$to = $employer['email'];
		MailSender::sendMail($to, $title, $content);
		echo $verificationCode;
	}
	
	public function subscribe_email() {
		$email = $this->input->post('email');
		$users = $this->db->query("SELECT * FROM `email_subscribers` WHERE `email`='" . $email . "'")->result_array();
		if (sizeof($users) <= 0) {
			$this->db->insert('users', array(
				'email' => $email
			));
		}
	}
	
	public function unsubscribe_email() {
		$email = $this->input->post('email');
		$this->db->where('email', $email);
		$this->db->delete('email_subscribers');
	}
	
	public function set_email_verified() {
		$userID = intval($this->input->post('user_id'));
		$verified = intval($this->input->post('verified'));
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'email_verified' => $verified
		));
	}
	
	public function set_phone_verified() {
		$userID = intval($this->input->post('user_id'));
		$verified = intval($this->input->post('verified'));
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'phone_verified' => $verified
		));
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
	
	public function add_experience() {
		$userID = intval($this->input->post('user_id'));
		$jobTitle = $this->input->post('job_title');
		$companyName = $this->input->post('company_name');
		$workingStart = $this->input->post('working_start');
		$workingEnd = $this->input->post('working_end');
		$currentlyWorking = intval($this->input->post('currently_working'));
		$specialization = $this->input->post('specialization');
		$workField = $this->input->post('work_field');
		$country = $this->input->post('country');
		$industry = $this->input->post('industry');
		$position = $this->input->post('position');
		$salary = intval($this->input->post('salary'));
		$salaryCurrency = $this->input->post('salary_currency');
		$workDescription = $this->input->post('work_description');
		$this->db->insert('experiences', array(
			'user_id' => $userID,
			'job_title' => $jobTitle,
			'company_name' => $companyName,
			'working_start' => $workingStart,
			'working_end' => $workingEnd,
			'currently_working' => $currentlyWorking,
			'specialization' => $specialization,
			'work_field' => $workField,
			'country' => $country,
			'industry' => $industry,
			'position' => $position,
			'salary' => $salary,
			'salary_currency' => $salaryCurrency,
			'work_description' => $workDescription
		));
	}
	
	public function update_experience() {
		$id = intval($this->input->post('id'));
		$userID = intval($this->input->post('user_id'));
		$jobTitle = $this->input->post('job_title');
		$companyName = $this->input->post('company_name');
		$workingStart = $this->input->post('working_start');
		$workingEnd = $this->input->post('working_end');
		$currentlyWorking = intval($this->input->post('currently_working'));
		$specialization = $this->input->post('specialization');
		$workField = $this->input->post('work_field');
		$country = $this->input->post('country');
		$industry = $this->input->post('industry');
		$position = $this->input->post('position');
		$salary = intval($this->input->post('salary'));
		$salaryCurrency = $this->input->post('salary_currency');
		$workDescription = $this->input->post('work_description');
		$this->db->where('id', $id);
		$this->db->update('experiences', array(
			'user_id' => $userID,
			'job_title' => $jobTitle,
			'company_name' => $companyName,
			'working_start' => $workingStart,
			'working_end' => $workingEnd,
			'currently_working' => $currentlyWorking,
			'specialization' => $specialization,
			'work_field' => $workField,
			'country' => $country,
			'industry' => $industry,
			'position' => $position,
			'salary' => $salary,
			'salary_currency' => $salaryCurrency,
			'work_description' => $workDescription
		));
	}
	
	public function add_education() {
		$userID = intval($this->input->post('user_id'));
		$institute = $this->input->post('institute');
		$graduationDate = $this->input->post('graduation_date');
		$qualification = $this->input->post('qualification');
		$country = $this->input->post('country');
		$studyField = $this->input->post('study_field');
		$major = $this->input->post('major');
		$grade = $this->input->post('grade');
		$description = $this->input->post('description');
		$this->db->insert('educations', array(
			'user_id' => $userID,
			'institute' => $institute,
			'graduation_date' => $graduationDate,
			'qualification' => $qualification,
			'country' => $country,
			'study_field' => $studyField,
			'major' => $major,
			'grade' => $grade,
			'description' => $description
		));
	}
	
	public function update_education() {
		$id = intval($this->input->post('id'));
		$userID = intval($this->input->post('user_id'));
		$institute = $this->input->post('institute');
		$graduationDate = $this->input->post('graduation_date');
		$qualification = $this->input->post('qualification');
		$country = $this->input->post('country');
		$studyField = $this->input->post('study_field');
		$major = $this->input->post('major');
		$grade = $this->input->post('grade');
		$description = $this->input->post('description');
		$this->db->where('id', $id);
		$this->db->update('educations', array(
			'user_id' => $userID,
			'institute' => $institute,
			'graduation_date' => $graduationDate,
			'qualification' => $qualification,
			'country' => $country,
			'study_field' => $studyField,
			'major' => $major,
			'grade' => $grade,
			'description' => $description
		));
	}
	
	public function get_experiences() {
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("SELECT * FROM `experiences`")->result_array());
	}
	
	public function get_educations() {
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("SELECT * FROM `educations`")->result_array());
	}
	
	public function get_experience_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `experiences` WHERE `id`=" . $id)->row_array());
	}
	
	public function get_education_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `educations` WHERE `id`=" . $id)->row_array());
	}
	
	public function delete_experience_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('experiences');
	}
	
	public function delete_education_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('educations');
	}
	
	public function get_skills() {
		$userID = intval($this->input->post('user_id'));
		$skills = [];
		$commonSkills = $this->db->query("SELECT * FROM `skills` WHERE `user_id`=" . $userID . " AND `type`='common'")->result_array();
		$specialistSkills = $this->db->query("SELECT * FROM `skills` WHERE `user_id`=" . $userID . " AND `type`='specialist'")->result_array();
		array_push($skills, array(
			'type' => 'common',
			'skills' => $commonSkills
		));
		array_push($skills, array(
			'type' => 'specialist',
			'skills' => $specialistSkills
		));
		echo json_encode($skills);
	}
	
	public function get_skills_by_type() {
		$userID = intval($this->input->post('user_id'));
		$type = $this->input->post('type');
		echo json_encode($this->db->query("SELECT * FROM `skills` WHERE `user_id`=" . $userID . " AND `type`='" . $type . "'")->result_array());
	}
	
	public function get_skill_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `skills` WHERE `id`=" . $id)->row_array());
	}
	
	public function add_skill() {
		$userID = intval($this->input->post('user_id'));
		$type = $this->input->post('type');
		$skill = $this->input->post('skill');
		$this->db->insert('skills', array(
			'user_id' => $userID,
			'type' => $type,
			'skill' => $skill
		));
	}
	
	public function update_skills() {
		$userID = intval($this->input->post('user_id'));
		$type = $this->input->post('type');
		$skills = json_decode($this->input->post('skills'), true);
		$this->db->query("DELETE FROM `skills` WHERE `user_id`=" . $userID . " AND `type`='" . $type . "'");
		for ($i=0; $i<sizeof($skills); $i++) {
			$this->db->insert('skills', array(
				'user_id' => $userID,
				'type' => $type,
				'skill' => $skills[$i]['skill']
			));
		}
	}
	
	public function delete_skill_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('skills');
	}
	
	public function get_languages() {
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("SELECT * FROM `languages`")->result_array());
	}
	
	public function get_language_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `languages` WHERE `id`=" . $id)->row_array());
	}
	
	public function add_language() {
		$userID = intval($this->input->post('user_id'));
		$language = $this->input->post('language');
		$spoken = intval($this->input->post('spoken'));
		$written = intval($this->input->post('written'));
		$primaryLanguage = intval($this->input->post('primary_language'));
		$this->db->insert('languages', array(
			'user_id' => $userID,
			'language' => $language,
			'spoken' => $spoken,
			'written' => $written,
			'primary_language' => $primaryLanguage
		));
	}
	
	public function update_language() {
		$id = intval($this->input->post('id'));
		$language = $this->input->post('language');
		$spoken = intval($this->input->post('spoken'));
		$written = intval($this->input->post('written'));
		$primaryLanguage = intval($this->input->post('primary_language'));
		$this->db->where('id', $id);
		$this->db->update('languages', array(
			'language' => $language,
			'spoken' => $spoken,
			'written' => $written,
			'primary_language' => $primaryLanguage
		));
	}
	
	public function delete_language_by_id() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('languages');
	}
	
	public function update_additional_info() {
		$userID = intval($this->input->post('user_id'));
		$expectedSalary = intval($this->input->post('expected_salary'));
		$expectedWorkLocation = $this->input->post('expected_work_location');
		$additionalInfo = $this->input->post('additional_info');
		$this->db->where('id', $userID);
		$this->db->update('users', array(
			'expected_salary' => $expectedSalary,
			'expected_work_location' => $expectedWorkLocation,
			'additional_info' => $additionalInfo
		));
	}
	
	public function upload_resume() {
		$userID = intval($this->input->post('user_id'));
		$config['upload_path']          = './userdata/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 2147483647;
        $config['file_name']            = Util::generateUUIDv4() . ".pdf";
        /*$config['max_width']            = 4096;
        $config['max_height']           = 4096;*/
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
        	$this->db->where('id', $userID);
        	$this->db->update('users', array(
        		'resume' => $this->upload->data()['file_name']
        	));
        } else {
        	echo json_encode($this->upload->display_errors());
        }
	}
	
	public function update_profile() {
		$userID = intval($this->input->post('id'));
		$firstName = $this->input->post('first_name');
		$lastName = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$profilePictureChanged = intval($this->input->post('profile_picture_changed'));
		if ($profilePictureChanged == 1) {
			$config['upload_path']          = './userdata/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = 2147483647;
	        $config['file_name']            = Util::generateUUIDv4();
	        $config['max_width']            = 15360;
	        $config['max_height']           = 8640;
	        $this->load->library('upload', $config);
	        if ($this->upload->do_upload('profile_picture')) {
	        	$this->db->where('id', $userID);
				$this->db->update('users', array(
					'first_name' => $firstName,
					'last_name' => $lastName,
					'email' => $email,
					'phone' => $phone,
					'address' => $address,
					'profile_picture' => $this->upload->data()['file_name']
				));
	        } else {
	        	echo json_encode($this->upload->display_errors());
	        }
		} else {
			$this->db->where('id', $userID);
			$this->db->update('users', array(
				'first_name' => $firstName,
				'last_name' => $lastName,
				'email' => $email,
				'phone' => $phone,
				'address' => $address
			));
		}
	}
	
	public function create_attendance() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$note = $this->input->post('note');
		$type = $this->input->post('type');
		$date = $this->input->post('date');
		$latitude = doubleval($this->input->post('latitude'));
		$longitude = doubleval($this->input->post('longitude'));
		$config['upload_path']          = './userdata/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 2147483647;
        $config['file_name']            = Util::generateUUIDv4();
        $config['max_width']            = 15360;
        $config['max_height']           = 8640;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('picture')) {
        	$this->db->insert('attendances', array(
        		'user_id' => $userID,
        		'job_id' => $jobID,
        		'picture' => $this->upload->data()['file_name'],
        		'note' => $note,
        		'lat' => $latitude,
        		'lng' => $longitude,
        		'type' => $type,
        		'date' => $date
        	));
        	$attendanceID = intval($this->db->insert_id());
        	$employerID = intval($this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $jobID)->row_array()['employer_id']);
        	$this->db->query("UPDATE `employees` SET `last_attendance_date`='" . $date . "' AND `last_attendance_type`='" . $type . "' WHERE `employer_id`=" . $employerID . " AND `user_id`=" . $userID . " AND `job_id`=" . $jobID);
        	if ($type == 'out') {
        		$this->db->insert('out_permission_requests', array(
        			'employer_id' => $employerID,
        			'job_id' => $jobID,
        			'user_id' => $userID,
        			'attendance_id' => $attendanceID,
        			'date' => $date
        		));
        		$employerOneSignalPlayerID = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . $employerID)->row_array()['onesignal_player_id'];
        		
        	}
        } else {
        	echo json_encode($this->upload->display_errors());
        }
	}
	
	public function get_attendances() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		echo json_encode($this->db->query("SELECT * FROM `attendances` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID ." ORDER BY `date` DESC")
			->result_array());
	}
	
	public function user_has_created_attendance() {
		$userID = intval($this->input->post('user_id'));
		$date = $this->input->post('date');
		$attendances = $this->db->query("SELECT * FROM `attendances` WHERE `user_id`=" . $userID . " AND DATE(`date`)='" . $date . "'")->result_array();
		if (sizeof($attendances) > 0) {
			echo 1;
		} else {
			echo -1;
		}
	}
	
	public function get_work_contracts() {
		$userID = intval($this->input->post('user_id'));
		$contracts = $this->db->query("SELECT * FROM `employees` WHERE `user_id`=" . $userID . " ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($contracts); $i++) {
			$contracts[$i]['employer'] = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . intval($contracts[$i]['employer_id']))->row_array();
			$contracts[$i]['requirements'] = $this->db->query("SELECT * FROM `job_requirements` WHERE `job_id`=" . intval($contracts[$i]['job_id']))->row_array();
			$contracts[$i]['benefits'] = $this->db->query("SELECT * FROM `job_benefits` WHERE `job_id`=" . intval($contracts[$i]['job_id']))->row_array();
			$contracts[$i]['job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . intval($contracts[$i]['job_id']))->row_array();
		}
		echo json_encode($contracts);
	}
	
	public function get_job_categories() {
		echo json_encode($this->db->query("SELECT * FROM `job_categories` ORDER BY `category`")->result_array());
	}
	
	public function get_job_subcategories() {
		$categoryID = intval($this->input->post('category_id'));
		echo json_encode($this->db->query("SELECT * FROM `job_subcategories` WHERE `job_category_id`=" . $categoryID . " ORDER BY `subcategory`")
			->result_array());
	}
	
	public function search_job() {
		$keyword = strtolower($this->input->post('keyword'));
		$categoryID = intval($this->input->post('category_id')); //0 if no category_id
		$subcategoryID = intval($this->input->post('subcategory_id')); //0 if no subcategory_id
		$jobs = [];
		if ($categoryID != 0 && $subcategoryID != 0) {
			$jobs = $this->db->query("SELECT * FROM `jobs` WHERE `category_id`=" . $categoryID . " AND `subcategory_id`=" . $subcategoryID . " AND `job_title` LIKE '%" . $keyword . "%'")->result_array();
		} else if ($categoryID != 0 && $subcategoryID == 0) {
			$jobs = $this->db->query("SELECT * FROM `jobs` WHERE `category_id`=" . $categoryID . " AND `job_title` LIKE '%" . $keyword . "%'")->result_array();
		} else if ($categoryID == 0 && $subcategoryID != 0) {
			$jobs = $this->db->query("SELECT * FROM `jobs` WHERE `subcategory_id`=" . $subcategoryID . " AND `job_title` LIKE '%" . $keyword . "%'")->result_array();
		} else if ($categoryID == 0 && $subcategoryID == 0) {
			$jobs = $this->db->query("SELECT * FROM `jobs` WHERE `job_title` LIKE '%" . $keyword . "%'")->result_array();
		}
		for ($i=0; $i<sizeof($jobs); $i++) {
			$jobs[$i]['employer'] = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . $jobs[$i]['employer_id'])->row_array();
			$jobs[$i]['requirements'] = $this->db->query("SELECT * FROM `job_requirements` WHERE `job_id`=" . $jobs[$i]['id'])->result_array();
			$jobs[$i]['benefits'] = $this->db->query("SELECT * FROM `job_benefits` WHERE `job_id`=" . $jobs[$i]['id'])->result_array();
		}
		echo json_encode($jobs);
	}
	
	public function add_to_favorite_job() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$this->db->insert('favorite_jobs', array(
			'user_id' => $userID,
			'job_id' => $jobID
		));
	}
	
	public function remove_from_favorite_job() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$this->db->where(array('user_id' => $userID, 'job_id' => $jobID));
		$this->db->delete('favorite_jobs');
	}
	
	public function send_message() {
		$title = json_decode($this->input->post('title'));
		$content = json_decode($this->input->post('content'));
		$data = json_decode($this->input->post('data'), true);
		$playerIDs = json_decode($this->input->post('ids'), true);
    	$fields = array(
        	'app_id' => "ec90b5e7-46bd-4636-b5dc-aa03657cf52c",
        	'data' => $data,
        	'large_icon' =>"ic_launcher.jpg",
        	'headings' => $title,
        	'contents' => $content
    	);
    	if (sizeof($playerIDs) > 0) {
    		$fields['include_player_ids'] = $playerIDs;
    	} else {
    		$fields['included_segments'] = array('All');
    	}
    	$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    		'Authorization: Basic ' . "YzUwYTc3NmItYjFiZi00MWQwLThlMTItMzE2YzBjZWNjYTBh"));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    	curl_setopt($ch, CURLOPT_HEADER, FALSE);
    	curl_setopt($ch, CURLOPT_POST, TRUE);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    	$response = curl_exec($ch);
    	curl_close($ch);
	}
	
	public function update_onesignal_player_id() {
		$id = intval($this->input->post('user_id'));
		$playerID = $this->input->post('player_id');
		$role = $this->input->post('role');
		$this->db->where('id', $id);
		if ($role == 'worker') {
			$this->db->update('users', array(
				'onesignal_player_id' => $playerID
			));
		} else if ($role == 'employer') {
			$this->db->update('employers', array(
				'onesignal_player_id' => $playerID
			));
		}
	}
	
	public function get_onesignal_player_id() {
		$id = intval($this->input->post('user_id'));
		$role = $this->input->post('role');
		if ($role == 'worker') {
			echo json_encode($this->db->query("SELECT * FROM `users` WHERE `id`=" . $id)->row_array()['onesignal_player_id']);
		} else if ($role == 'employer') {
			echo json_encode($this->db->query("SELECT * FROM `employers` WHERE `id`=" . $id)->row_array()['onesignal_player_id']);
		}
	}
	
	public function apply_job() {
		$jobID = intval($this->input->post('job_id'));
		$userID = intval($this->input->post('user_id'));
		$employerID = intval($this->input->post('employer_id'));
		$introduction = $this->input->post('introduction');
		$date = $this->input->post('date');
		$this->db->insert('employees', array(
			'job_id' => $jobID,
			'user_id' => $userID,
			'employer_id' => $employerID,
			'introduction' => $introduction,
			'date' => $date,
			'status' => 'pending_review'
		));
	}
	
	public function is_job_applied() {
		$jobID = intval($this->input->post('job_id'));
		$userID = intval($this->input->post('user_id'));
		$employerID = intval($this->input->post('employer_id'));
		$jobs = $this->db->query("SELECT * FROM `employees` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID . " AND `employer_id`=" . $employerID)
			->result_array();
		if (sizeof($jobs) > 0) {
			echo 1;
		} else {
			echo 0;
		}
	}
	
	public function is_favorite_job() {
		$jobID = intval($this->input->post('job_id'));
		$userID = intval($this->input->post('user_id'));
		$jobs = $this->db->query("SELECT * FROM `favorite_jobs` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID)->result_array();
		if (sizeof($jobs) > 0) {
			echo 1;
		} else {
			echo 0;
		}
	}
	
	public function get_job_by_id() {
		$jobID = intval($this->input->post('id'));
		$job = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $jobID)->row_array();
		$job['employer'] = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . intval($job['employer_id']))->row_array();
		$job['requirements'] = $this->db->query("SELECT * FROM `job_requirements` WHERE `job_id`=" . intval($job['id']))->result_array();
		$job['benefits'] = $this->db->query("SELECT * FROM `job_benefits` WHERE `job_id`=" . intval($job['id']))->result_array();
		echo json_encode($job);
	}
	
	public function get_work_deletion_reasons() {
		echo json_encode($this->db->query("SELECT * FROM `job_contract_delete_reasons`")->result_array());
	}
	
	public function send_contract_deletion_request() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$employerID = intval($this->input->post('employer_id'));
		$reason = $this->input->post('reason');
		$date = $this->input->post('date');
		$this->db->query("DELETE FROM `contract_deletion_requests` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID . " AND `employer_id`=" . $employerID);
		$this->db->insert('contract_deletion_requests', array(
			'user_id' => $userID,
			'job_id' => $jobID,
			'employer_id' => $employerID,
			'reason' => $reason,
			'date' => $date
		));
		$this->db->query("UPDATE `employees` SET `status`='request_deletion' WHERE `employer_id`=" . $employerID . " AND user_id=" . $userID . " AND job_id=" . $jobID);
	}
	
	public function get_job_documents() {
		$jobID = intval($this->input->post('job_id'));
		echo json_encode($this->db->query("SELECT * FROM `job_documents` WHERE `job_id`=" . $jobID)->result_array());
	}
	
	public function get_tasks() {
		$employerID = intval($this->input->post('employer_id'));
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("SELECT * FROM `tasks` WHERE `employer_id`=" . $employerID . " AND `user_id`=" . $userID)->result_array());
	}
	
	public function get_e_trainings() {
		$employerID = intval($this->input->post('employer_id'));
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("SELECT * FROM `documents` WHERE `employer_id`=" . $employerID . " AND `user_id`=" . $userID)->result_array());
	}
	
	public function get_notifications() {
		$userID = intval($this->input->post('user_id'));
		$notifications = $this->db->query("SELECT * FROM `notifications` WHERE `user_id`=" . $userID . " ORDER BY `date` DESC")->result_array();
		for ($i=0; $i<sizeof($notifications); $i++) {
			$notification = $notifications[$i];
			$senderType = $notification['sender_type'];
			$senderID = intval($notification['sender_id']);
			if ($senderType == 'superadmin') {
				$notifications[$i]['sender'] = $this->db->query("SELECT * FROM `admins` WHERE `id`=" . $senderID)->row_array();
			} else if ($senderType == 'employer') {
				$notifications[$i]['sender'] = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . $senderID)->row_array();
			}
		}
		echo json_encode($notifications);
	}
	
	public function is_out_allowed() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$date = $this->input->post('date');
		$attendance = $this->db->query("SELECT * FROM `attendances` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID . " AND DATE(`date`)='" . $date . "' AND `type`='out'")->row_array();
		if ($attendance == NULL) {
			echo -1;
		} else {
			echo $attendance['out_allowed'];
		}
	}
	
	public function ask_out_permission() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$employerID = intval($this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $jobID)->row_array()['employer_id']);
		$date = $this->input->post('date');
		$this->db->insert('attendances', array(
			
		));
	}
	
	public function get_banners() {
		echo json_encode($this->db->query("SELECT * FROM `banners`")->result_array());
	}
	
	public function get_all_jobs() {
		$jobs = $this->db->query("SELECT * FROM `jobs` ORDER BY `post_date` DESC LIMIT 10")->result_array();
		for ($i=0; $i<sizeof($jobs); $i++) {
			$jobs[$i]['employer'] = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . $jobs[$i]['employer_id'])->row_array();
			$jobs[$i]['requirements'] = $this->db->query("SELECT * FROM `job_requirements` WHERE `job_id`=" . $jobs[$i]['id'])->result_array();
			$jobs[$i]['benefits'] = $this->db->query("SELECT * FROM `job_benefits` WHERE `job_id`=" . $jobs[$i]['id'])->result_array();
		}
		echo json_encode($jobs);
	}
	
	public function get_favorite_jobs() {
		$userID = intval($this->input->post('user_id'));
		$favoriteJobs = $this->db->query("SELECT * FROM `favorite_jobs` WHERE `user_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($favoriteJobs); $i++) {
			$job = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $favoriteJobs[$i]['job_id'])->row_array();
			if ($job != NULL) {
				$job['employer'] = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . $job['employer_id'])->row_array();
				$job['requirements'] = $this->db->query("SELECT * FROM `job_requirements` WHERE `job_id`=" . $job['id'])
					->result_array();
				$job['benefits'] = $this->db->query("SELECT * FROM `job_benefits` WHERE `job_id`=" . $job['id'])->result_array();
			} else {
				$job = array(
					'employer' => NULL,
					'requirements' => NULL,
					'benefits' => NULL
				);
			}
			$favoriteJobs[$i]['job'] = $job;
		}
		echo json_encode($favoriteJobs);
	}
	
	public function get_viewed_jobs() {
		$userID = intval($this->input->post('user_id'));
		$viewedJobs = $this->db->query("SELECT * FROM `viewed_jobs` WHERE `user_id`=" . $userID)->result_array();
		for ($i=0; $i<sizeof($viewedJobs); $i++) {
			$job = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $viewedJobs[$i]['job_id'])->row_array();
			if ($job != NULL) {
				$job['employer'] = $this->db->query("SELECT * FROM `employers` WHERE `id`=" . $job['employer_id'])->row_array();
				$job['requirements'] = $this->db->query("SELECT * FROM `job_requirements` WHERE `job_id`=" . $job['id'])
					->result_array();
				$job['benefits'] = $this->db->query("SELECT * FROM `job_benefits` WHERE `job_id`=" . $job['id'])->result_array();
			}
			$viewedJobs[$i]['job'] = $job;
		}
		echo json_encode($viewedJobs);
	}
	
	public function view_job() {
		$userID = intval($this->input->post('user_id'));
		$jobID = intval($this->input->post('job_id'));
		$date = $this->input->post('date');
		$jobs = $this->db->query("SELECT * FROM `viewed_jobs` WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID)->result_array();
		if (sizeof($jobs) > 0) {
			$this->db->query("UPDATE `viewed_jobs` SET `date`='" . $date . "' WHERE `user_id`=" . $userID . " AND `job_id`=" . $jobID);
		} else {
			$this->db->insert('viewed_jobs', array(
				'user_id' => $userID,
				'job_id' => $jobID,
				'date' => $date
			));
		}
	}
	
	public function get_chat_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `chats` WHERE `id`=" . $id)->row_array());
	}
	
	public function start_chat() {
		$user1ID = intval($this->input->post('user_1_id'));
		$user2ID = intval($this->input->post('user_2_id'));
		$user1Type = $this->input->post('user_1_type');
		$user2Type = $this->input->post('user_2_type');
		$chats = $this->db->query("SELECT * FROM `chats` WHERE `user_1`=" . $user1ID . " AND `user_2`=" . $user2ID . " AND `user_1_type`='" . $user1Type . "' AND `user_2_type`='" . $user2Type . "'")->result_array();
		$chatID = 0;
		if (sizeof($chats) <= 0) {
			$this->db->insert('chats', array(
				'user_1' => $user1ID,
				'user_2' => $user2ID,
				'user_1_type' => $user1Type,
				'user_2_type' => $user2Type
			));
			$chatID = $this->db->insert_id();
		} else {
			$chatID = $chats[0]['id'];
		}
		echo $chatID;
	}
	
	public function send_chat_message() {
		$chatID = intval($this->input->post('chat_id'));
		$senderID = intval($this->input->post('sender_id'));
		$senderType = $this->input->post('sender_type');
		$receiverID = intval($this->input->post('receiver_id'));
		$receiverType = $this->input->post('receiver_type');
		$message = $this->input->post('message');
		$date = $this->input->post('date');
		if ($receiverType == 'worker' || $receiverType == 'employee') {
			$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverID)->row_array();
			$fcmID = $user['fcm_id'];
			FCM::send_message('Pesan baru', strlen($message)>30?substr($message, 0, 30) . "...":$message, $fcmID, array());
		}
		$this->db->insert('chat_messages', array(
			'chat_id' => $chatID,
			'sender_id' => $senderID,
			'sender_type' => $senderType,
			'receiver_id' => $receiverID,
			'receiver_type' => $receiverType,
			'message' => $message,
			'date' => $date
		));
		$messageID = intval($this->db->insert_id());
		echo json_encode($this->db->query("SELECT * FROM `chat_messages` WHERE `id`=" . $messageID)->row_array());
	}
	
	public function get_chat_messages() {
		$chatID = intval($this->input->post('chat_id'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$messages = $this->db->query("SELECT * FROM `chat_messages` WHERE `chat_id`=" . $chatID . " ORDER BY `date` DESC LIMIT " . $start . "," . $length)->result_array();
		echo json_encode($messages);
	}
	
	public function update_fcm_id() {
		$userID = intval($this->input->post('user_id'));
		$fcmID = $this->input->post('fcm_id');
		$this->db->query("UPDATE `users` SET `fcm_id`='" . $fcmID . "' WHERE `id`=" . $userID);
	}
	
	public function get_profile_info() {
		$userID = intval($this->input->post('user_id'));
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		$employees = $this->db->query("SELECT * FROM `employees` WHERE `user_id`=" . $userID)->result_array();
		$totalWorkExperience = 0;
		for ($i=0; $i<sizeof($employees); $i++) {
			$workingStart = $employees[$i]['date'];
			$workingEnd = $employees[$i]['date_out'];
			if ($workingEnd == NULL || $workingEnd.trim() == "null" || $workingEnd.trim() == "NULL") {
				$workingEnd = date("Y-m-d H:i:s");
			}
			$totalWorkExperience += (strtotime($workingEnd)-strtotime($workingStart));
		}
		$user['total_work_experience'] = $totalWorkExperience;
		$currentJobID = intval($user['current_job_id']);
		if ($currentJobID != 0) {
			$user['current_job'] = $this->db->query("SELECT * FROM `jobs` WHERE `id`=" . $currentJobID)->row_array();
		} else {
			$user['current_job'] = NULL;
		}
		$user['educations'] = $this->db->query("SELECT * FROM `educations` WHERE `user_id`=" . $userID)->result_array();
		echo json_encode($user);
	}
	
	public function check_password() {
		$userID = intval($this->input->post('user_id'));
		$password = $this->input->post('password');
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		if ($user['password'] == $password) {
			echo 1;
		} else {
			echo -1;
		}
	}
	
	public function change_password() {
		$userID = intval($this->input->post('user_id'));
		$password = $this->input->post('password');
		$this->db->query("UPDATE `users` SET `password`='" . $password . "' WHERE `id`=" . $userID);
	}
}
