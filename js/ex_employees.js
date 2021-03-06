var employees = [];

$(document).ready(function() {
	getExEmployees();
});

function getExEmployees() {
	employees = [];
	$("#employees").find("*").remove();
	let userID = localStorage.getItem("user_id");
	let fd = new FormData();
	fd.append("employer_id", userID);
	fetch(PHP_URL+"/employer/get_ex_employees", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			employees = JSON.parse(response);
			for (let i=0; i<employees.length; i++) {
				let employee = employees[i];
				let month = parseInt(employee['month']);
				month = (month==0?"January":month==1?"February":month==2?"March":month==3?"April"
					:month==4?"May":month==5?"June":month==6?"July":month==7?"August"
						:month==8?"September":month==9?"Oktober":month==10?"November"
							:month==11?"December":'');
				$("#employees").append("<tr>" +
					"                                        <th scope=\"row\">"+(i+1)+"</th>" +
					"                                        <td>"+employee['transaction_id']+"</td>" +
					"                                        <td>"+month+"</td>" +
					"                                        <td>"+employee['year']+"</td>" +
					"                                        <td>"+employee['num_employees']+"</td>" +
					"                                        <th scope=\"row\"><input id='check-"+employee['id']+"' type='checkbox' disabled "+(parseInt(employee['taxable'])==1?"checked":"")+"></th>" +
					"                                        <td><button onclick='edit("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Edit</button></td>" +
					"                                        <td><button onclick='confirmDelete("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Hapus</button></td>" +
					"                                    </tr>");
			}
		});
}

function add() {
	window.location.href = "http://localhost/admin/payroll/add_ex_employee";
}

function edit(index) {
	$.redirect(PHP_URL+"/payroll/edit_ex_employee", {
		'id': employees[index]['id']
	});
}

function confirmDelete(index) {
	if (confirm("Are you sure you want to delete this data?")) {
		let fd = new FormData();
		fd.append("id", employees[index]['id']);
		fetch(PHP_URL+"/employer/delete_ex_employee", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				getExEmployees();
			});
	}
}
