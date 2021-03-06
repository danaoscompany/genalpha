var selectedProfilePicture = null;

$(document).ready(function() {
	$("#select-profile-picture").on("change", function(e) {
		selectedProfilePicture = e.target.files[0];
		let fr = new FileReader();
		fr.onload = function(e) {
			$("#profile-picture").attr("src", e.target.result);
		};
		fr.readAsDataURL(selectedProfilePicture);
	});
	let fd = new FormData();
	fd.append("id", localStorage.getItem("user_id"));
	fetch(PHP_URL+"/employer/get_employer_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let obj = JSON.parse(response);
			$("#profile-picture").attr("src", USERDATA_URL+obj['profile_picture']);
		});
});

function changeProfilePicture() {
	$("#select-profile-picture").click();
}

function upload() {
	if (selectedProfilePicture == null) {
		alert("Mohon pilih foto profil");
		return;
	}
	let fd = new FormData();
	fd.append("id", localStorage.getItem("user_id"));
	fd.append("file", selectedProfilePicture);
	fetch(PHP_URL+"/employer/update_profile_picture", {
		method: 'post',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.reload();
		});
}
