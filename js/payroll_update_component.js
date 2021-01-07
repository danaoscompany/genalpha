let monthNames = [
	"Semua", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
	"November", "Desember"
];
var components = [];

$(document).ready(function() {
	for (let i=0; i<monthNames.length; i++) {
		$("#months").append("<li class=\"nav-item\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t<a href=\"javascript:selectMonth("+i+");\" class=\"nav-link\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"nav-link-icon lnr-inbox\"></i>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t<span>\n" +
			"                                                            "+monthNames[i]+"\n" +
			"                                                        </span>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t</a>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t</li>");
	}
	let startYear = parseInt(moment(new Date()).format('YYYY'));
	for (let i=startYear-2; i<=startYear+10; i++) {
		$("#years").append("<li class=\"nav-item\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t<a href=\"javascript:selectYear("+i+");\" class=\"nav-link\">\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"nav-link-icon lnr-inbox\"></i>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t\t<span>\n" +
			"                                                            "+i+"\n" +
			"                                                        </span>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t\t</a>\n" +
			"\t\t\t\t\t\t\t\t\t\t\t</li>");
	}
	getComponents();
});

function getComponents() {
	components = [];
	$("#components").find("*").remove();
	let fd = new FormData();
	fd.append("employer_id", parseInt(localStorage.getItem('user_id')));
	fd.append("month", -1);
	fd.append("year", -1);
	fd.append("keyword", "");
	fetch(PHP_URL+'/employer/get_payroll_components', {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			components = JSON.parse(response);
			for (let i=0; i<components.length; i++) {
				let component = components[i];
				$("#components").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<th scope=\"row\">"+(i+1)+"</th>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+component['transaction_id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+component['transaction_type']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+component['component_name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+component['component_type']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+component['effective_date']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button onclick='editComponent("+i+")' class='btn-shadow p-1 btn btn-primary btn-sm show-toastr-example'>Ubah</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td><button onclick='deleteComponent("+i+")' class='btn-shadow p-1 btn btn-danger btn-sm show-toastr-example'>Hapus</button></td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
}

function editComponent(index) {
	$.redirect(PHP_URL+"/payroll/edit_component", {
		'id': components[index]['id']
	});
}

function deleteComponent(index) {
	if (confirm("Apakah Anda yakin ingin menghapus komponen berikut?")) {
		let fd = new FormData();
		fd.append("id", components[index]['id']);
		fetch(PHP_URL+"/employer/delete_component", {
			method: 'POST',
			body: fd
		})
			.then(response => response.text())
			.then(async (response) => {
				getComponents();
			});
	}
}

function selectMonth(month) {

}
