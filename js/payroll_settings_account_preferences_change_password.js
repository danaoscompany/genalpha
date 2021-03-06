function save() {
	let oldPassword = $("#old-password").val();
	let newPassword = $("#new-password").val();
	let repeatedPassword = $("#repeated-password").val();
	if (oldPassword.trim() == "" || newPassword.trim() == "" || repeatedPassword.trim() == "") {
		alert("Mohon lengkapi data");
		return;
	}
	if (newPassword != repeatedPassword) {
		alert("Kata sandi tidak sama");
		return;
	}
	let fd = new FormData();
	fd.append("id", localStorage.getItem("user_id"));
	fd.append("old_password", oldPassword);
	fd.append("new_password", newPassword);
	fetch(PHP_URL+"/employer/update_password", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			if (obj['response_code'] == 1) {
				window.location.reload();
			} else if (obj['response_code'] == -1) {
				alert("Kata sandi lama yang Anda masukkan salah");
			}
		});
}
