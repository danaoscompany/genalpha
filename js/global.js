const HOST = "localhost/admin";
const PHP_URL = "http://"+HOST;
const USERDATA_URL = "http://"+HOST+"/userdata/";
const SYSTEMDATA_URL = "http://"+HOST+"/systemdata/";

$(document).ready(function() {
	let userRole = localStorage.getItem("user_role");
	if (userRole == "superadmin") {
		$("#payroll-menu").css("display", "none");
		$("#superadmin-menu").css("display", "block");
		$("#employer-menu").css("display", "block");
		$("#employee-menu").css("display", "block");
	} else if (userRole == "employer") {
		$("#payroll-menu").css("display", "block");
		$("#superadmin-menu").css("display", "none");
		$("#employer-menu").css("display", "none");
		$("#employee-menu").css("display", "none");
	} else {
		$("#payroll-menu").css("display", "none");
		$("#superadmin-menu").css("display", "none");
		$("#employer-menu").css("display", "none");
		$("#employee-menu").css("display", "none");
	}
	let userID = parseInt($("#admin-id").val());
	let fd = new FormData();
	fd.append("id", userID);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/get_admin_by_id",
		data: fd,
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

Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
	var n = this,
		decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
		decSeparator = decSeparator == undefined ? "." : decSeparator,
		thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
		sign = n < 0 ? "-" : "",
		i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
		j = (j = i.length) > 3 ? j % 3 : 0;
	return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};

function uuidv4() {
	return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
		var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
		return v.toString(16);
	});
}

function logout() {
	if (confirm("Apakah Anda yakin ingin keluar?")) {
		window.location.href = "http://localhost/admin/logout";
	}
}

function downloadFile(url) {
	var link = document.createElement("a");
	link.setAttribute('download', name);
	link.href = url;
	document.body.appendChild(link);
	link.click();
	link.remove();
}
