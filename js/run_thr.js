var employees = [];
var checkedEmployees = [];

$(document).ready(function() {
	getEmployees();
});

function getEmployees() {
	let userId = localStorage.getItem("user_id");
	let fd = new FormData();
	fd.append("employer_id", userId);
	fetch(PHP_URL+"/employer/get_employees", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			employees = JSON.parse(response);
			for (let i=0; i<employees.length; i++) {
				let employee = employees[i];
				$("#employees").append("<tr>" +
					"                                        <th scope=\"row\"><div class=\"position-relative form-check\"><input name=\"check\" id=\"check-"+employee['id']+"\" type=\"checkbox\" onchange='refreshEmployeesCount()' class=\"form-check-input\"><label for=\"exampleCheck\" class=\"form-check-label\"></label></div></th>" +
					"                                        <td>"+(i+1)+"</td>" +
					"                                        <td>"+employee['user']['first_name']+" "+employee['user']['last_name']+"</td>" +
					"                                        <td>"+employee['user']['email']+"</td>" +
					"                                        <td>"+employee['user']['phone']+"</td>" +
					"                                    </tr>");
			}
		});
}

function refreshEmployeesCount() {
	checkedEmployees = [];
	for (let i=0; i<employees.length; i++) {
		let checked = $("#check-"+employees[i]['id']).prop('checked');
		if (checked) {
			checkedEmployees.push(employees[i]['id']);
		}
	}
}

function runTHR() {
	alert(JSON.stringify(checkedEmployees));
}
