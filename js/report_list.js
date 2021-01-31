var reports = [];
var category = "";

$(document).ready(function() {
	category = $("#category").val().trim();
	getReports();
});

function getReports() {
	reports = [];
	let userID = localStorage.getItem("user_id");
	let fd = new FormData();
	fd.append("employer_id", userID);
	fd.append("category", category);
	fetch(PHP_URL+"/employer/get_reports", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			reports = JSON.parse(response);
			for (let i=0; i<reports.length; i++) {
				let report = reports[i];
				$("#reports").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+report['name']+" "+"</td>" +
					"                                        <td><button onclick='downloadReport("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Download</button></td>" +
					"                                    </tr>");
			}
		});
}

function downloadReport(index) {
	let report = reports[index];
	let downloadURL = USERDATA_URL+report['path'];
	var link = document.createElement("a");
	link.setAttribute('download', report['name']);
	link.href = downloadURL;
	document.body.appendChild(link);
	link.click();
	link.remove();
}
