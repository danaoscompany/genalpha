var componentID = 0;
var componentNames = [];
var transactionTypes = [];
var payrollData = null;
var selectedComponentNameID = 0;
var selectedTransactionTypeID = 0;
var allEmployees = [];
var selectedDate = null;

$(document).ready(function() {
	componentID = parseInt($("#id").val().trim());
	$("#effective-date").on('change', function() {
		if (componentNames.length == 0) {
			return;
		}
		selectedDate = $("#effective-date").val();
		getEmployeeData();
	});
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
				let currentAmount = parseInt(sheet[i]['old amount']);
				let newAmount = parseInt(sheet[i]['new amount']);
				payrollData = [];
				$("#employees").find("*").remove();
				payrollData.push({
					'employee_id': employeeID,
					'employee': {
						'id': employeeID
					},
					'current_amount': currentAmount,
					'new_amount': newAmount
				});
				$("#employees").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<th scope=\"row\"><input id='check-employee-"+employeeID+"' type='checkbox'></th>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+employeeID+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+fullName+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+currentAmount.formatMoney(0, ',', '.')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><input id='new-amount-"+i+"' onchange='updateDataNewAmount("+i+")' class='form-control' type='number' value='"+newAmount+"'>"+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button onclick='deleteEmployee("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		};
		fr.readAsDataURL(file);
	});
	$("#backpay").on('change', function() {
		if ($(this).prop('checked')) {
			$("#backpay-date-container").css("display", "block");
		} else {
			$("#backpay-date-container").css("display", "none");
		}
	});
	let fd = new FormData();
	fd.append("employer_id", localStorage.getItem('user_id'));
	fetch(PHP_URL+"/employer/get_employees", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			allEmployees = JSON.parse(response);
			$("#component-name").find("*").remove();
			fetch(PHP_URL+"/employer/get_component_names")
				.then(response => response.text())
				.then(async (response) => {
					componentNames = JSON.parse(response);
					if (componentNames.length > 0) {
						selectedComponentNameID = parseInt(componentNames[0]['id']);
						$("#transaction-type").attr("disabled", true);
					}
					for (let i=0; i<componentNames.length; i++) {
						$("#component-name").append("<option>"+componentNames[i]['name']+"</option>");
					}
					$("#transaction-type").find("*").remove();
					fetch(PHP_URL+"/employer/get_transaction_types")
						.then(response => response.text())
						.then(async (response) => {
							transactionTypes = JSON.parse(response);
							if (transactionTypes.length > 0) {
								selectedTransactionTypeID = parseInt(transactionTypes[0]['id']);
							}
							for (let i=0; i<transactionTypes.length; i++) {
								$("#transaction-type").append("<option>" + transactionTypes[i]['name'] + "</option>");
							}
							getComponentInfo();
						});
				});
		});
	$("#component-name").on('change', function() {
		let selectedComponentName = componentNames[$("#component-name").prop('selectedIndex')];
		let componentNameID = parseInt(selectedComponentName['id']);
		selectedComponentNameID = componentNameID;
		if (selectedComponentName['name'] == 'Basic Salary') {
			selectedComponentNameID = parseInt(componentNames[0]['id']);
			$("#transaction-type").attr("disabled", true);
		} else {
			$("#transaction-type").attr("disabled", false);
		}
		getEmployeeData();
	});
	$("#transaction-type").on('change', function() {
		let transactionTypeID = parseInt(transactionTypes[$("#transaction-type").prop('selectedIndex')]['id']);
		selectedTransactionTypeID = transactionTypeID;
		getEmployeeData();
	});
});

function getComponentInfo() {
	let fd = new FormData();
	fd.append("id", componentID);
	fetch(PHP_URL+"/employer/get_component", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			let componentInfo = JSON.parse(response);
			$("#effective-date").val(componentInfo['effective_date']);
			selectedDate = moment(componentInfo['effective_date'], 'YYYY-MM-DD').toDate();
			let backpayEnabled = parseInt(componentInfo['backpay_enabled'])==1;
			$("#backpay").prop('checked', backpayEnabled);
			if (backpayEnabled) {
				$("#backpay-date-container").css("display", "block");
			} else {
				$("#backpay-date-container").css("display", "none");
			}
			$("#backpay-date").val(componentInfo['backpay_date']);
			for (let i=0; i<componentNames.length; i++) {
				if (parseInt(componentInfo['component_name_id']) == parseInt(componentNames[i]['id'])) {
					$('#component-name').prop('selectedIndex', i);
					break;
				}
			}
			for (let i=0; i<transactionTypes.length; i++) {
				if (parseInt(componentInfo['transaction_type_id']) == parseInt(transactionTypes[i]['id'])) {
					$('#transaction-type').prop('selectedIndex', i);
					break;
				}
			}
			$("#description").val(componentInfo['description']);
			payrollData = componentInfo['payroll_data'];
			for (let i=0; i<payrollData.length; i++) {
				let employee = payrollData[i]['employee'];
				$("#employees").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<th scope=\"row\"><input id='check-employee-"+payrollData[i]['employee_id']+"' type='checkbox' checked></th>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+payrollData[i]['employee_id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+employee['first_name']+" "+employee['last_name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+parseInt(payrollData[i]['current_amount']).formatMoney(0, ',', '.')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><input id='new-amount-"+i+"' onchange='updateDataNewAmount("+i+")' class='form-control' type='number' value='"+payrollData[i]['new_amount']+"'>"+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button onclick='deleteData("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function getEmployeeData() {
	payrollData = [];
	$("#employees").find("*").remove();
	let fd = new FormData();
	fd.append("employer_id", localStorage.getItem("user_id"));
	fd.append("component_name_id", selectedComponentNameID);
	fd.append("transaction_type_id", selectedTransactionTypeID);
	fetch(PHP_URL+"/employer/get_employee_payroll_data", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			payrollData = JSON.parse(response);
			for (let i=0; i<payrollData.length; i++) {
				let employee = payrollData[i]['employee'];
				$("#employees").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<th scope=\"row\"><input id='check-employee-"+employee['id']+"' type='checkbox'></th>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+payrollData[i]['employee_id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+employee['first_name']+" "+employee['last_name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+parseInt(payrollData[i]['current_amount']).formatMoney(0, ',', '.')+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><input id='new-amount-"+i+"' onchange='updateDataNewAmount("+i+")' class='form-control' type='number' value='"+payrollData[i]['new_amount']+"'>"+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button onclick='deleteEmployee("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function updateDataNewAmount(index) {
	let newAmount = $("#new-amount-"+index).val().trim();
	if (newAmount != "") {
		newAmount = parseInt(newAmount);
	}
	payrollData[index]['new_amount'] = newAmount;
}

function save() {
	let description = $("#description").val().trim();
	let userID = parseInt(localStorage.getItem("user_id"));
	let fd = new FormData();
	fd.append("payroll_component_id", componentID);
	fd.append("employer_id", userID);
	fd.append("transaction_id", ""+userID+moment(new Date()).format('YYYYMMDDHHmmss'));
	fd.append("transaction_type_id", transactionTypes[$("#transaction-type").prop('selectedIndex')]['id']);
	fd.append("component_name_id", transactionTypes[$("#component-name").prop('selectedIndex')]['id']);
	fd.append("effective_date", moment(selectedDate).format('YYYY-MM-DD'));
	let checkedPayrollData = [];
	for (let i=0; i<payrollData.length; i++) {
		let checked = $("#check-employee-"+payrollData[i]['employee_id']).prop('checked');
		if (checked) {
			checkedPayrollData.push(payrollData[i]);
		}
	}
	fd.append("payroll_data", JSON.stringify(checkedPayrollData));
	fd.append("description", description);
	fd.append("backpay_enabled", $("#backpay").prop('checked')?1:0);
	fd.append("backpay_date", $("#backpay-date").val().trim());
	fd.append("date_added", moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
	fetch(PHP_URL+"/employer/update_payroll_component", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			window.location.href = PHP_URL+"/payroll/update_component";
		});
}

function cancel() {
	if (confirm("Apakah Anda yakin ingin batal merubah komponen berikut?")) {
		window.history.back();
	}
}

function deleteEmployee(index) {
	if (confirm("Apakah Anda yakin ingin menghapus karyawan yang dipilih?")) {
		payrollData.splice(index, 1);
		$("#employees tr:eq(" + index + ")").remove();
	}
}

function aleradyInList(id) {
	for (let i=0; i<payrollData.length; i++) {
		if (parseInt(payrollData[i]['employee_id']) == id) {
			return true;
		}
	}
	return false;
}

function add() {
	if (selectedDate == null) {
		alert("Mohon pilih tanggal efektif");
		return;
	}
	if (allEmployees.length == 0) {
		return;
	}
	$("#added-employees").find("*").remove();
	$("#amount").val("");
	$("#add-employee").css("display", "flex");
	for (let i=0; i<allEmployees.length; i++) {
		let employee = allEmployees[i];
		if (!aleradyInList(parseInt(employee['id']))) {
			$("#added-employees").append("<tr>\n" +
				"\t\t\t\t<th scope=\"row\"><input id='added-employee-" + (i + 1) + "' type='checkbox'></th>\n" +
				"\t\t\t\t<td>" + (i + 1) + "</td>\n" +
				"\t\t\t\t<td>" + employee['id'] + "</td>\n" +
				"\t\t\t\t<td>" + employee['user']['first_name'] + " " + employee['user']['last_name'] + "</td>\n" +
				"\t\t\t</tr>");
		}
	}
}

function addComponent() {
	let amount = $("#amount").val().trim();
	if (amount == "") {
		alert("Mohon masukkan jumlah baru");
		return;
	}
	amount = parseInt(amount);
	let totalChecked = 0;
	for (let i=0; i<allEmployees.length; i++) {
		let checked = $("#added-employee-"+(i+1)).prop("checked");
		if (checked) {
			totalChecked++;
		}
	}
	if (totalChecked == 0) {
		alert("Mohon pilih karyawan");
		return;
	}
	$("#add-employee").fadeOut();
	for (let i=0; i<allEmployees.length; i++) {
		let checked = $("#added-employee-"+(i+1)).prop("checked");
		if (checked) {
			let employee = allEmployees[i];
			$("#employees").append("<tr>\n" +
				"\t\t\t\t\t\t\t\t\t\t<th scope=\"row\"><input id='check-employee-"+employee['id']+"' type='checkbox'></th>\n" +
				"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
				"\t\t\t\t\t\t\t\t\t\t<td>"+employee['id']+"</td>\n" +
				"\t\t\t\t\t\t\t\t\t\t<td>"+employee['user']['first_name']+" "+employee['user']['last_name']+"</td>\n" +
				"\t\t\t\t\t\t\t\t\t\t<td>baru</td>\n" +
				"\t\t\t\t\t\t\t\t\t\t<td><input id='new-amount-"+i+"' onchange='updateDataNewAmount("+i+")' class='form-control' type='number' value='"+amount+"'>"+"</td>\n" +
				"\t\t\t\t\t\t\t\t\t\t<td><button onclick='deleteEmployee("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Hapus</button></td>\n" +
				"\t\t\t\t\t\t\t\t\t</tr>");
			payrollData.push({
				'employee_id': parseInt(employee['id']),
				'employee': employee,
				'current_amount': 0,
				'new_amount': amount
			});
		}
	}
}

function _import() {
	$("#import-xls").click();
}

function _export() {
	var wb = XLSX.utils.book_new();
	var ws_name = "Worksheet";
	var ws_data = [
		[ "id employee", "full name", "old amount", "new amount" ]
	];
	for (let i=0; i<payrollData.length; i++) {
		ws_data.push([
			payrollData[i]['employee_id'],
			payrollData[i]['employee']['first_name']+" "+payrollData[i]['employee']['last_name'],
			payrollData[i]['current_amount'],
			payrollData[i]['new_amount']
		]);
	}
	var ws = XLSX.utils.aoa_to_sheet(ws_data);
	XLSX.utils.book_append_sheet(wb, ws, ws_name);
	XLSX.writeFile(wb, uuidv4()+'.xls');
}

function reset() {
	if (selectedDate == null) {
		alert("Mohon pilih tanggal efektif");
		return;
	}
	if (allEmployees.length == 0) {
		return;
	}
	if (confirm("Apakah Anda yakin ingin mengatur ulang data tabel payroll?")) {
		getEmployeeData();
	}
}

function _delete() {
	if (selectedDate == null) {
		alert("Mohon pilih tanggal efektif");
		return;
	}
	if (allEmployees.length == 0) {
		return;
	}
	if (confirm("Apakah Anda yakin ingin menghapus karyawan yang dipilih?")) {
		for (let i = 0; i < payrollData.length; i++) {
			let checked = $("#check-employee-" + payrollData[i]['employee_id']).prop('checked');
			if (checked) {
				payrollData.splice(i, 1);
				$("#employees").find("tr:eq("+i+")").remove();
			}
		}
	}
}
