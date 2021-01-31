var users = [];
var selectedUserIndex = 0;

$(document).ready(function() {
	getEmployers();
	let userID = parseInt($("#admin-id").val());
	let fd = new FormData();
	fd.append("cmd", "SELECT * FROM `admins` WHERE `id`="+userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/main/query",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			var obj = JSON.parse(response)[0];
			$("#admin-name").html(obj['name']);
			$("#admin-email").html(obj['email']);
		}
	});
});

function getEmployers() {
	$("#employers").find("*").remove();
	$.ajax({
		type: 'GET',
		url: PHP_URL+'/admin/get_employers',
		cache: false,
		success: function(response) {
			users = JSON.parse(response);
			for (let i=0; i<users.length; i++) {
				let user = users[i];
				$("#employers").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+user['first_name']+" "+user['last_name']+"</td>" +
					"                                        <td>"+user['email']+"</td>" +
					"                                        <td>"+user['password']+"</td>" +
					"                                        <td>"+user['phone']+"</td>" +
					"                                        <td>"+moment(user['birthday']).format('DD MMMM YYYY hh:mm:ss')+"</td>" +
					"                                        <td><button onclick='viewUser("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Lihat</button></td>" +
					"                                        <td><button onclick='confirmDeleteUser("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example' data-toggle='modal' data-target='#confirm'>Delete</button></td>" +
					"                                    </tr>");
			}
		}
	});
}

function viewDevices(index) {
	var user = users[index];
	$.redirect("http://genalpha.id/admin/devices", {
		id: parseInt(user['id'])
	});
}

function viewPatients(index) {
	var user = users[index];
	$.redirect("http://genalpha.id/admin/patients", {
		id: parseInt(user['id'])
	});
}

function viewUser(index) {
	var user = users[index];
	$.redirect("http://genalpha.id/admin/employer/view", {
		'employer_id': parseInt(user['id'])
	});
}

function confirmDeleteUser(index) {
	selectedUserIndex = index;
	$("#confirmLabel").html("Delete User");
	$("#confirmBody").html("Are you sure you want to delete this user?");
	$("#confirm").modal('show');
}

function deleteUser() {
	var userID = users[selectedUserIndex]['id'];
	let fd = new FormData();
	fd.append("id", userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+'/admin/delete_user',
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			getEmployers();
		}
	});
}
