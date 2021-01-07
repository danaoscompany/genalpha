var employers = [];
var jobs = [];
var employees = [];
var attendances = [];
var selectedEmployerID = 0;
var selectedJobID = 0;
var selectedUserID = 0;

$(document).ready(function() {
	let userRole = localStorage.getItem('user_role');
	let userID = parseInt(localStorage.getItem('user_id'));
	if (userRole == 'employer') {
		$("#choose-employer").css("display", "none");
		selectedEmployerID = userID;
	}
	$("#employer").on("click", function() {
		$("#search-employer").css("display", "flex").hide().fadeIn();
	});
	$("#job").on("click", function() {
		$("#search-job").css("display", "flex").hide().fadeIn();
	});
	$("#employee").on("click", function() {
		employees = [];
		$("#employees").find("*").remove();
		$("#search-employee").css("display", "flex").hide().fadeIn();
		searchEmployee();
	});
});

function searchEmployer() {
	let keyword = $("#keyword").val().trim();
	if (keyword == "") return;
	employers = [];
	$("#employers").find("*").remove();
	let fd = new FormData();
	fd.append("keyword", keyword);
	fetch(PHP_URL+"/admin/search_employer", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			employers = JSON.parse(response);
			for (let i=0; i<employers.length; i++) {
				let employer = employers[i];
				$("#employers").append("<li style=\"width: 100%; height: 80px; display: flex; flex-direction: column;\">\n" +
					"\t\t\t\t<div style=\"width: calc(100% - 16px); margin-left: 8px; margin-right: 8px; height: 1px;\n" +
					"\t\t\t\t\tbackground-color: rgba(136, 136, 136, .3)\" />\n" +
					"\t\t\t\t<div style=\"width: 100%; display: flex; flex-direction: row; align-items: center; margin-top: 16px;\">\n" +
					"\t\t\t\t\t<img src=\""+(employer["profile_picture"]==null||employer["profile_picture"].trim()==""
						?"http://localhost/admin/systemdata/profile_picture_placeholder.png"
						:USERDATA_URL+employer["profile_picture"].trim())+"\"\n" +
					"\t\t\t\t\t\t width=\"50px\" height=\"50px\" style=\"margin-left: 8px; border-radius: 25px;\">\n" +
					"\t\t\t\t\t<div style=\"display: flex; flex-direction: row; justify-content: space-between;\n" +
					"\t\t\t\t\t\t\talign-items: center; width: 100%;\">\n" +
					"\t\t\t\t\t\t<div style=\"display: flex; flex-direction: column; margin-left: 16px; margin-right: 16px;\">\n" +
					"\t\t\t\t\t\t\t<div style=\"color: #000000; font-size: 15px;\">"+employer['first_name']+" "+employer['last_name']+"</div>\n" +
					"\t\t\t\t\t\t\t<div style=\"color: rgba(0, 0, 0, 0.4); font-size: 15px; margin-top: 0px;\">\n" +
					"\t\t\t\t\t\t\t\t"+employer['email']+"\n" +
					"\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t<button class=\"mb-2 mr-2 btn btn-info\" onclick='selectEmployer("+i+")'>Pilih</button>\n" +
					"\t\t\t\t\t</div>\n" +
					"\t\t\t\t</div>\n" +
					"\t\t\t</li>");
			}
		});
}

function searchJob() {
	let keyword = $("#job-keyword").val().trim();
	if (keyword == "") return;
	jobs = [];
	$("#jobs").find("*").remove();
	let fd = new FormData();
	fd.append("keyword", keyword);
	fd.append("employer_id", selectedEmployerID);
	fetch(PHP_URL+"/admin/search_job", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			jobs = JSON.parse(response);
			for (let i=0; i<jobs.length; i++) {
				let job = jobs[i];
				$("#jobs").append("<li style=\"width: 100%; height: 80px; display: flex; flex-direction: column;\">\n" +
					"\t\t\t\t<div style=\"width: calc(100% - 16px); margin-left: 8px; margin-right: 8px; height: 1px;\n" +
					"\t\t\t\t\tbackground-color: rgba(136, 136, 136, .3)\" />\n" +
					"\t\t\t\t<div style=\"width: 100%; display: flex; flex-direction: row; align-items: center; margin-top: 16px;\">\n" +
					"\t\t\t\t\t<img src=\""+(job["logo"]==null||job["logo"].trim()==""
						?"http://localhost/admin/systemdata/profile_picture_placeholder.png"
						:USERDATA_URL+job["logo"].trim())+"\"\n" +
					"\t\t\t\t\t\t width=\"50px\" height=\"50px\" style=\"margin-left: 8px; border-radius: 25px;\">\n" +
					"\t\t\t\t\t<div style=\"display: flex; flex-direction: row; justify-content: space-between;\n" +
					"\t\t\t\t\t\t\talign-items: center; width: 100%;\">\n" +
					"\t\t\t\t\t\t<div style=\"display: flex; flex-direction: column; margin-left: 16px; margin-right: 16px;\">\n" +
					"\t\t\t\t\t\t\t<div style=\"color: #000000; font-size: 15px;\">"+job['job_title']+"</div>\n" +
					"\t\t\t\t\t\t\t<div style=\"color: rgba(0, 0, 0, 0.4); font-size: 15px; margin-top: 0px;\">\n" +
					"\t\t\t\t\t\t\t\t"+job['country']+"\n" +
					"\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t<button class=\"mb-2 mr-2 btn btn-info\" onclick='selectJob("+i+")'>Pilih</button>\n" +
					"\t\t\t\t\t</div>\n" +
					"\t\t\t\t</div>\n" +
					"\t\t\t</li>");
			}
		});
}

function searchEmployee() {
	let fd = new FormData();
	fd.append("employer_id", selectedEmployerID);
	fd.append("job_id", selectedJobID);
	fetch(PHP_URL+"/admin/get_employees", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			console.log(response);
			employees = JSON.parse(response);
			for (let i=0; i<employees.length; i++) {
				let employee = employees[i];
				$("#employees").append("<li style=\"width: 100%; height: 80px; display: flex; flex-direction: column;\">\n" +
					"\t\t\t\t<div style=\"width: calc(100% - 16px); margin-left: 8px; margin-right: 8px; height: 1px;\n" +
					"\t\t\t\t\tbackground-color: rgba(136, 136, 136, .3)\" />\n" +
					"\t\t\t\t<div style=\"width: 100%; display: flex; flex-direction: row; align-items: center; margin-top: 16px;\">\n" +
					"\t\t\t\t\t<img src=\""+(employee['user']["profile_picture"]==null||employee['user']["profile_picture"].trim()==""
						?"http://localhost/admin/systemdata/profile_picture_placeholder.png"
						:USERDATA_URL+employee['user']["profile_picture"].trim())+"\"\n" +
					"\t\t\t\t\t\t width=\"50px\" height=\"50px\" style=\"margin-left: 8px; border-radius: 25px;\">\n" +
					"\t\t\t\t\t<div style=\"display: flex; flex-direction: row; justify-content: space-between;\n" +
					"\t\t\t\t\t\t\talign-items: center; width: 100%;\">\n" +
					"\t\t\t\t\t\t<div style=\"display: flex; flex-direction: column; margin-left: 16px; margin-right: 16px;\">\n" +
					"\t\t\t\t\t\t\t<div style=\"color: #000000; font-size: 15px;\">"+employee['user']['first_name']+" "+employee['user']['last_name']+"</div>\n" +
					"\t\t\t\t\t\t\t<div style=\"color: rgba(0, 0, 0, 0.4); font-size: 15px; margin-top: 0px;\">\n" +
					"\t\t\t\t\t\t\t\t"+employee['user']['email']+"\n" +
					"\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t<button class=\"mb-2 mr-2 btn btn-info\" onclick='selectEmployee("+i+")'>Pilih</button>\n" +
					"\t\t\t\t\t</div>\n" +
					"\t\t\t\t</div>\n" +
					"\t\t\t</li>");
			}
		});
}

function selectEmployee(index) {
	let employee = employees[index];
	selectedUserID = parseInt(employee['user_id']);
	$("#search-employee").fadeOut();
	$("#employee").val(employee['user']['first_name']+" "+employee['user']['last_name']);
	getAttendances();
}

function getAttendances() {
	let fd = new FormData();
	fd.append("user_id", selectedUserID);
	fd.append("job_id", selectedJobID);
	fetch(PHP_URL+"/admin/get_attendances", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			attendances = JSON.parse(response);
			for (let i=0; i<attendances.length; i++) {
				let attendance = attendances[i];
				$("#attendances").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t<th scope=\"row\">\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t<td><img src=\""+USERDATA_URL+attendance['picture']+"\" width=\"150px\" height=\"150px\"></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t<td>"+attendance['note']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t<td>"+moment(attendance['date'], 'YYYY-MM-DD HH:mm:ss').format('D MMMM YYYY HH:mm:ss')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t<td>"+attendance['location']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t<td>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t<button class=\"mt-2 btn btn-info\" style=\"\" onclick=\"viewLocation("+i+")\">Lihat\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t</button>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t</th>\n" +
					"\t\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function viewLocation(index) {
	let attendance = attendances[index];
	$.redirect('https://www.google.com/maps/@'+attendance['lat']+","+attendance['lng'], null, 'GET', '_blank');
}

function selectEmployer(index) {
	let employer = employers[index];
	$("#search-employer").fadeOut();
	$("#employer").val(employer['first_name']+" "+employer['last_name']);
	selectedEmployerID = parseInt(employer['id']);
}

function selectJob(index) {
	let job = jobs[index];
	selectedJobID = parseInt(job['id']);
	$("#search-job").fadeOut();
	$("#job").val(job['job_title']);
}

function getJobs() {
	employees = [];
	$("#employees").find("*").remove();
	let fd = new FormData();
	fd.append("employer_id", selectedEmployerID);
	fd.append("job_id", selectedJobID);
	fetch(PHP_URL+"/admin/get_employees", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			employees = JSON.parse(response);
			for (let i=0; i<employees.length; i++) {
				let employee = employees[i];
				$("#employees").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+employee['user']['first_name']+" "+employee['user']['last_name']+"</td>" +
					"                                        <td>"+employee['user']['email']+"</td>" +
					"                                        <td>"+employee['user']['password']+"</td>" +
					"                                        <td>"+employee['user']['phone']+"</td>" +
					"                                        <td>"+moment(employee['user']['birthday']).format('DD MMMM YYYY hh:mm:ss')+"</td>" +
					"                                        <td><button onclick='viewEmployee("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Lihat</button></td>" +
					"                                        <td><button onclick='confirmDeleteUser("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Delete</button></td>" +
					"                                    </tr>");
			}
		});
}

function viewJob(index) {
	let job = jobs[index];
	$.redirect(PHP_URL+"/job/view", {
		job_id: parseInt(job['id'])
	});
}

function viewEmployee(index) {
	let employee = employees[index];
	$.redirect(PHP_URL+"/employee/view", {
		user_id: employee['user_id']
	});
}
