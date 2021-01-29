<?php

include 'MailSender.php';
include 'Util.php';

class Test extends CI_Controller {

	public function index() {
		$this->load->view('test');
	}

	public function pdf() {
		$this->load->view('pdf');
	}
	
	public function send_email_2() {
		$verificationCode = $this->input->post('verification_code');
		$title = "Kinerjaku.id - " . $verificationCode . " adalah kode verifikasi Anda";
		$displayedVerificationCode = $verificationCode[0] . " " . $verificationCode[1] . " " . $verificationCode[2] . " " . $verificationCode[3] .
			" " . $verificationCode[4] . " " . $verificationCode[5];
		$content = file_get_contents('systemdata/email_templates/verification_en.html');	
		$content = str_replace("[verificationCode]", $displayedVerificationCode, $content);
		$to = $this->input->post('to');
		MailSender::sendMail($to, $title, $content);
	}
	
	public function one_signal() {
		$content = array(
        	"en" => 'Testing Message'
        );
    	$fields = array(
        	'app_id' => "ec90b5e7-46bd-4636-b5dc-aa03657cf52c",
        	//'included_segments' => array('All'),
        	'include_player_ids' => array('2f65b8f7-93d6-4371-a596-bd042705d852'),
        	'data' => array("foo" => "bar"),
        	'large_icon' =>"ic_launcher.jpg",
        	'contents' => $content
    	);
    	$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    		'Authorization: Basic YzUwYTc3NmItYjFiZi00MWQwLThlMTItMzE2YzBjZWNjYTBh'));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    	curl_setopt($ch, CURLOPT_HEADER, FALSE);
    	curl_setopt($ch, CURLOPT_POST, TRUE);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    	$response = curl_exec($ch);
    	curl_close($ch);
	}
	
	public function delete() {
		unlink("userdata/test.txt");
	}
	
	public function a() {
		for ($i=100; $i>=98; $i--) {
			$this->db->query("UPDATE `users` SET `birthday`='2000-10-10' WHERE `email`='employee" . $i . "@gmail.com'");
		}
		for ($i=98; $i>=88; $i--) {
			$this->db->query("UPDATE `users` SET `birthday`='1998-10-10' WHERE `email`='employee" . $i . "@gmail.com'");
		}
		for ($i=88; $i>=48; $i--) {
			$this->db->query("UPDATE `users` SET `birthday`='1993-10-10' WHERE `email`='employee" . $i . "@gmail.com'");
		}
		for ($i=48; $i>=13; $i--) {
			$this->db->query("UPDATE `users` SET `birthday`='1984-10-10' WHERE `email`='employee" . $i . "@gmail.com'");
		}
		for ($i=13; $i>=1; $i--) {
			$this->db->query("UPDATE `users` SET `birthday`='1973-10-10' WHERE `email`='employee" . $i . "@gmail.com'");
		}
	}
	
	public function b() {
		for ($j=1; $j<=10; $j++) {
			for ($i=0; $i<30; $i++) {
				$this->db->query("INSERT INTO `attendances` (`id`, `user_id`, `job_id`, `picture`, `note`, `lat`, `lng`, `location`, `date`) VALUES (NULL, " . $j . ", '1', '92a379ad-3ef1-4692-989d-4c838fcab1e7', 'Sedang makan siang', '-6.2088', '106.8456', 'Jakarta, Indonesia', DATE_ADD(NOW(), INTERVAL -" . $i . " DAY)) ");
			}
		}
	}
	
	public function c() {
		for ($i=2; $i<=10; $i++) {
			$this->db->query("INSERT INTO `employees` (`id`, `employer_id`, `user_id`, `job_id`, `introduction`, `date`, `status`) VALUES (NULL, '1', " . $i . ", '1', 'Ini tentang saya 1', '2020-12-07 18:02:06', 'approved')");
		}
	}
	
	public function d() {
		$dt = new DateTime('2020-10-10');
		echo $dt->format('w');
	}
	
	public function e() {
		for ($i=1; $i<=40; $i++) {
			$this->db->query("INSERT INTO `religions` (`user_id`, `religion`) VALUES (" . $i . ", 'islam')");
		}
		for ($i=40; $i<=70; $i++) {
			$this->db->query("INSERT INTO `religions` (`user_id`, `religion`) VALUES (" . $i . ", 'kristen')");
		}
		for ($i=70; $i<=87; $i++) {
			$this->db->query("INSERT INTO `religions` (`user_id`, `religion`) VALUES (" . $i . ", 'hindu')");
		}
		for ($i=87; $i<=95; $i++) {
			$this->db->query("INSERT INTO `religions` (`user_id`, `religion`) VALUES (" . $i . ", 'buddha')");
		}
		for ($i=95; $i<=100; $i++) {
			$this->db->query("INSERT INTO `religions` (`user_id`, `religion`) VALUES (" . $i . ", 'konghucu')");
		}
	}
	
	public function f() {
		for ($i=1; $i<=100; $i++) {
			$this->db->query("INSERT INTO `employees` (`id`, `employer_id`, `user_id`, `job_id`, `introduction`, `date`, `type`, `status`) VALUES (NULL, '1', " . $i . ", '1', 'Ini tentang saya 1', '2020-12-07 18:02:06', 'permanent', 'approved')");
		}
	}
	
	public function g() {
		for ($i=1; $i<=70; $i++) {
			$this->db->query("UPDATE `users` SET `gender`='male' WHERE `id`=" . $i);
		}
		for ($i=70; $i<=100; $i++) {
			$this->db->query("UPDATE `users` SET `gender`='female' WHERE `id`=" . $i);
		}
	}
	
	public function h() {
		$dt = new DateTime('2020-10-10 10:00:00');
		$dt->modify("-1 month");
		echo $dt->format('Y:m:d H:i:s');
	}
	
	public function i() {
		echo $this->db->query("SELECT * FROM `notifications` LIMIT 1")->row_array()['title'];
		//echo "Selamat Tahun Baru Masehi 2021 🎆 !!";
	}

	public function j() {
		$j = 100;
		for ($i=99; $i>=0; $i--) {
			$this->db->where('id', $i);
			$this->db->update('employees', array(
				'id' => $j
			));
			$j--;
		}
	}

	public function k() {
		$users = $this->db->query("SELECT * FROM `users`")->result_array();
		for ($i=0; $i<sizeof($users); $i++) {
			$this->db->where('id', intval($users[$i]['id']));
			$this->db->update('users', array(
				'last_name' => '' . ($i+1)
			));
		}
	}
	
	public function face_recognition() {
		$img1URL = $this->input->post('img_1_url');
		$img2URL = $this->input->post('img_2_url');
		$output=null;
		$retval=null;
		exec("python3 /home/dana/Documents/Python/FaceRecognition/main.py --img1url http://localhost/img1.jpg --img2url http://localhost/img2.jpg",
			$output, $retval);
		print_r($output[0]. "\n");
	}
	
	public function l() {
		exec("node /home/dana/Documents/Web/shellcommand/index.js");
	}
	
	public function upload_face_1() {
		$config['upload_path']          = './userdata/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 2147483647;
        $config['file_name']            = "face1.jpg";
        $config['overwrite'] 			= TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
        	echo $this->upload->data()['file_name'];
        }
	}
	
	public function upload_face_2() {
		$config['upload_path']          = './userdata/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 2147483647;
        $config['file_name']            = "face2.jpg";
        $config['overwrite'] 			= TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
        	echo $this->upload->data()['file_name'];
        }
	}

	public function send_email() {
		$this->email->from('localhost@localhost', 'Gen Alpha');
		$this->email->to('danaoscompany@gmail.com');
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');
		$this->email->attach('userdata/sample.pdf');
		if($this->email->send())
			$this->session->set_flashdata("email_sent","Email sent successfully.");
		else
			$this->session->set_flashdata("email_sent","Error in sending Email.");
	}

	public function send_email_3() {
		MailSender::sendMailWithAttachments('danaoscompany@gmail.com', 'This is subject',
			'This is body', array(
				'userdata/5a7d1d1a-6a20-4363-9cf4-7ee9aa0a413f'
			));
	}
	
	public function m() {
		for ($i=1; $i<=4; $i++) {
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Have knowledge of programming languages (Java, or JavaScript)'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Have excellent communication skills and ability to work with a team'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Have strong motivation to learn new things and upgrading competencies in every aspect'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Can generate and working with REST API'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'SQL knowledge (Oracle / Postgresql / MongoDB / Cassandra) **picks one or more'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Agile development knowledge'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Minimum education diploma in information'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Optional (Oracle Netsuite SuiteScript 2.0, Oracle Netsuite Functional, Angularjs Framework, NodeJS, OpenAPI 3.0 or Swagger)'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Project Based Salary'
			));
			$this->db->insert('job_requirements', array(
				'job_id' => $i,
				'title' => 'Location Surabaya'
			));
		}
	}
	
	public function n() {
		for ($i=1; $i<=4; $i++) {
			$this->db->query("INSERT INTO `job_benefits` (`job_id`, `benefit`) VALUES (" . $i . ", 'Tunjangan transportasi, tunjangan makan, tunjangan anak, BPJS ketenagakerjaan.')");
		}
	}
}
