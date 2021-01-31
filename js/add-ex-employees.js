var years = [];
var employees = [];
var selectedEmployees = [];
var amounts = [];

$(document).ready(function() {
	$("#import-xls").on("change", function(e) {
		let file = e.target.files[0];
		let fr = new FileReader();
		fr.onloadend = function(e) {
			let data = e.target.result;
			data = data.substr(data.indexOf(",")+1, data.length);
			var workbook = XLSX.read(data, {'type': 'base64'});
			var sheet = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
			for (let i=0; i<sheet.length; i++) {
				let employeeID = parseInt(sheet[i]['id employee']);
				let fullName = sheet[i]['full name'];
				let resignDate = parseInt(sheet[i]['resign date']);
				let amount = parseInt(sheet[i]['amount']);
				selectedEmployees.push({
					'id': employeeID,
					'full_name': fullName,
					'resign_date': resignDate,
					'amount': amount
				});
				$("#selected-employees").append("<tr id='selected-employee-"+employeeID+"'>" +
					"                                        <th scope=\"row\"><input id='check-selected-employee-" + employeeID + "' type='checkbox'></th>" +
					"                                        <td>" + (i + 1) + "</td>" +
					"                                        <td>" + employeeID + "</td>" +
					"                                        <td>" + fullName + "</td>" +
					"                                        <td>" + moment(resignDate, 'YYYY-MM-DD').format('DD MMMM YYYY') + "</td>" +
					"                                        <td><input name=\"amount\" id=\"amount-" + employeeID + "\" placeholder=\"Enter amount\" type=\"number\" class=\"form-control\" value='"+amount+"' onchange='checkAmount(" + i + ", "+employeeID+")'></td>" +
					"                                        <td><button onclick='delete(" + i + ")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Delete</button></td>" +
					"                                    </tr>");
			}
		};
		fr.readAsDataURL(file);
	});
	let currentYear = parseInt(moment(new Date()).format('YYYY'));
	let currentMonth = parseInt(moment(new Date()).format('MM'));
	let startYear = currentYear-3;
	let endYear = currentYear+3;
	for (let i=startYear; i<=endYear; i++) {
		years.push(i);
		$("#years").append("<option value='"+i+"'>"+i+"</option>");
	}
	for (let i=0; i<years.length; i++) {
		let year = years[i];
		if (year == currentYear) {
			$('#years option').eq(i).prop('selected', true);
			break;
		}
	}
	for (let i=1; i<=12; i++) {
		if (currentMonth == i) {
			$('#months option').eq(i-1).prop('selected', true);
			break;
		}
	}
	getEmployees();
});

function getEmployees() {
	let userID = localStorage.getItem("user_id");
	let fd = new FormData();
	fd.append("employer_id", userID);
	fetch(PHP_URL+"/employer/get_resigned_employees", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			employees = JSON.parse(response);
			for (let i=0; i<employees.length; i++) {
				amounts.push(0);
			}
			for (let i=0; i<employees.length; i++) {
				let employee = employees[i];
				$("#employees").append("<tr>" +
					"                                        <th scope=\"row\"><input id='check-"+employee['id']+"' type='checkbox' onchange='checkEmployee("+i+")'></th>" +
					"                                        <td>"+(i+1)+"</td>" +
					"                                        <td>"+employee['id']+"</td>" +
					"                                        <td>"+employee['user']['first_name']+" "+employee['user']['last_name']+"</td>" +
					"                                        <td>"+moment(employee['date_out']).format('DD MMMM YYYY')+"</td>" +
					"                                    </tr>");
			}
		});
}

function checkEmployee(index) {
	let employee = employees[index];
	let checked = $("#check-"+employee['id']).prop('checked');
	if (checked) {
		selectedEmployees.push(employee);
		$("#selected-employees").append("<tr id='selected-employee-"+employee['id']+"'>" +
			"                                        <th scope=\"row\"><input id='check-selected-employee-" + employee['id'] + "' type='checkbox'></th>" +
			"                                        <td>" + (index + 1) + "</td>" +
			"                                        <td>" + employee['id'] + "</td>" +
			"                                        <td>" + employee['user']['first_name'] + " " + employee['user']['last_name'] + "</td>" +
			"                                        <td>" + moment(employee['date_out']).format('DD MMMM YYYY') + "</td>" +
			"                                        <td><input name=\"amount\" id=\"amount-" + employee['id'] + "\" placeholder=\"Enter amount\" type=\"number\" class=\"form-control\" value='"+amounts[index]+"' onchange='checkAmount(" + index + ", "+employee['id']+")'></td>" +
			"                                        <td><button onclick='delete(" + index + ")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Delete</button></td>" +
			"                                    </tr>");
	} else {
		selectedEmployees.splice(index, 1);
		$("#selected-employee-"+employee['id']).remove();
	}
}

function checkAmount(index, employeeID) {
	amounts[index] = parseInt($("#amount-"+employeeID).val());
}

function saveEmployees() {

}

function _import() {
	$("#import-xls").click();
}

function _export() {
	var wb = XLSX.utils.book_new();
	var ws_name = "Worksheet";
	var ws_data = [
		[ "id employee", "full name", "resign date", "amount" ]
	];
	for (let i=0; i<selectedEmployees.length; i++) {
		let employee = selectedEmployees[i];
		ws_data.push([
			employee['id'],
			employee['user']['first_name']+" "+employee['user']['last_name'],
			moment(employee['date_out']).format('YYYY-MM-DD'),
			amounts[i]
		]);
	}
	var ws = XLSX.utils.aoa_to_sheet(ws_data);
	XLSX.utils.book_append_sheet(wb, ws, ws_name);
	XLSX.writeFile(wb, uuidv4()+'.xls');
}

function _delete() {
	if (confirm("Are you sure you want to delete selected employees?")) {
		for (let i=0; i<selectedEmployees.length; i++) {
			let employee = selectedEmployees[i];
			$("#selected-employee-"+employee['id']).remove();
		}
	}
}

function save() {
	let userID = localStorage.getItem("user_id");
	let fd = new FormData();
	fd.append("employer_id", userID);
	fd.append("description", $("#description").val());
	fd.append("month", $("#months").prop('selectedIndex')+1);
	fd.append("year", years[$("#years").prop('selectedIndex')]);
	fd.append("num_employees", selectedEmployees.length);
	fd.append("taxable", $("#taxable").prop('checked')?"1":"0");
	fd.append("employees", JSON.stringify(selectedEmployees));
	fd.append("amounts", JSON.stringify(amounts));
	fetch(PHP_URL+"/employer/add_ex_employee", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.history.back();
		});
}
