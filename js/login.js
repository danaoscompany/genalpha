$(document).ready(function() {
});

function login() {
	let fd = new FormData();
	let email = $("#email").val().trim();
	let password = $("#password").val();
	if (email == "" || password == "") {
		alert("Mohon masukkan email dan kata sandi");
		return;
	}
	fd.append("email", email);
	fd.append("password", password);
	fetch(PHP_URL+"/admin/login", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			let obj = JSON.parse(response);
			var responseCode = parseInt(obj['response_code']);
			var userID = parseInt(obj['user_id']);
			let userRole = obj['user_role'];
			localStorage.setItem("user_role", userRole);
			localStorage.setItem("user_id", ""+userID);
			if (responseCode == 1) {
				if (userRole == 'superadmin') {
					window.location.href = "http://genalpha.id/admin/user";
				} else if (userRole == 'employer') {
					window.location.href = "http://genalpha.id/admin/job";
				}
			} else if (responseCode == -1) {
				alert("Email atau kata sandi yang Anda masukkan salah.");
			} else if (responseCode == -2) {
				alert("Email atau kata sandi yang Anda masukkan salah.");
			}
		});
}

