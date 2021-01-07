var userID = 0;
var prevEmail = "";
var prevPhone = "";
var resumeURL = "";

$(document).ready(function() {
	userID = parseInt($("#user-id").val().trim());
	let fd = new FormData();
	fd.append("id", userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/get_user_by_id",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var user = JSON.parse(response);
			prevEmail = user['email'];
			prevPhone = user['phone'];
			$("#email").val(prevEmail);
			$("#password").val(user['password']);
			$("#first-name").val(user['first_name']);
			$("#last-name").val(user['last_name']);
			$("#phone").val(prevPhone);
			$("#address").val(user['address']);
			$("#profile-picture").attr("src", USERDATA_URL+user['profile_picture']);
			$("#expected-salary").val(user['expected_salary']);
			$("#expected-work-location").val(user['expected_work_location']);
			$("#additional-info").val(user['additional_info']);
			resumeURL = USERDATA_URL+user['resume'];
		}
	});
	var adminID = parseInt($("#admin-id").val().trim());
	let fd2 = new FormData();
	fd2.append("id", adminID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/get_by_id",
		data: fd2,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response);
			$("#admin-name").html(obj['name']);
			$("#admin-email").html(obj['email']);
		}
	});
});

function save() {
	let email = $("#email").val().trim();
	let password = $("#password").val().trim();
	let name = $("#name").val().trim();
	let phone = $("#phone").val().trim();
	let birthday = $("#birthday").val().trim();
	let position = parseInt($("#positions").prop('selectedIndex'));
	if (email == "" || password == "" || name == "" || phone == "" || birthday == "") {
		alert("Mohon lengkapi data");
		return;
	}
	let role = "customer";
	if (position == 2) {
		role = "store";
	} else if (position == 3) {
		role = "owner";
	}
	let fd = new FormData();
	fd.append("id", userID);
	fd.append("email", email);
	fd.append("password", password);
	fd.append("name", name);
	fd.append("role", role);
	fd.append("phone", phone);
	fd.append("birthday", birthday);
	if (prevEmail != email) {
		fd.append("email_changed", 1);
	} else {
		fd.append("email_changed", 0);
	}
	if (prevPhone != phone) {
		fd.append("phone_changed", 1);
	} else {
		fd.append("phone_changed", 0);
	}
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/update_user",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response);
			var responseCode = parseInt(obj['response_code']);
			if (responseCode == -1) {
				alert("Email sudah digunakan");
			} else if (responseCode == -2) {
				alert("Nomor HP sudah digunakan");
			} else {
				window.history.back();
			}
		}
	});
}

function cancelEditing() {
	window.history.back();
}

function viewResume() {
	$.redirect("http://localhost/admin/pdf/view", {
		url: resumeURL
	}, 'POST', '_blank');
}
