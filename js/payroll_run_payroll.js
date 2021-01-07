var employees = [];
var years = [];

$(document).ready(function() {
	let currentYear = parseInt(moment(new Date()).format('YYYY'));
	let startYear = currentYear-10;
	let selectedIndex = 0;
	let j = 0;
	for (let i=startYear; i<=(startYear+15); i++) {
		$("#years").append("<option>"+i+"</option>");
		years.push(i);
		if (i == currentYear) {
			selectedIndex = j;
		}
		j++;
	}
	$("#years").prop('selectedIndex', selectedIndex);
	let fd = new FormData();
	fd.append("employer_id", localStorage.getItem("user_id"));
	fetch(PHP_URL+"/employer/get_employees", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(async (response) => {
			employees = JSON.parse(response);
			for (let i=0; i<employees.length; i++) {
				let employee = employees[i];
				$("#employees").append("<tr>\n" +
					"\t\t\t\t\t\t\t\t\t\t<th scope=\"row\"><input id='check-employee-"+employee['id']+"' type='checkbox'></th>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+(i+1)+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+employee['id']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+employee['user']['first_name']+" "+employee['user']['last_name']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+employee['job']['job_title']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t\t<td>"+employee['job']['position']+"</td>\n" +
					"\t\t\t\t\t\t\t\t\t</tr>");
			}
		});
});

function runPayroll() {
	let checkedEmployees = [];
	for (let i=0; i<employees.length; i++) {
		let employee = employees[i];
		let checked = $("#check-employee-"+employee['id']).prop('checked');
		if (checked) {
			checkedEmployees.push(parseInt(employee['id']));
		}
	}
	$.redirect(PHP_URL+"/payroll/run_start", {
		'employees': JSON.stringify(checkedEmployees),
		// TODO uncomment this
		/*'year': years[$("#years").prop('selectedIndex')],
		'month': $("#months").prop('selectedIndex')*/
		'year': 2020,
		'month': 11
	});
}

function runPayroll2() {
}

function makePDF() {
	var doc = new jsPDF();
	doc.text('SLIP GAJI KARYAWAN', 130, 10);
	doc.text("___________________", 130, 11);
	doc.setFontType("bold");
	doc.setFontSize(11);
	doc.text("ID", 10, 30);
	doc.text(":", 40, 30);
	doc.text(employee['id'], 50, 30);
	doc.text(employee['user']['first_name']+" "+employee['user']['last_name'], 60, 30);
	doc.text("___________________________________________", 10, 32);
	doc.text("Periode", 10, 40);
	doc.text(":", 40, 40);
	doc.text(moment([years[$("#years").prop('selectedIndex')], $("#months").prop('selectedIndex'), 1]).format('YYYYMM'), 50, 40);
	doc.text("Posisi", 10, 45);
	doc.text(":", 40, 45);
	doc.text(employee['job']['job_title'], 50, 45);
	doc.text("_________________________________________________________________________________", 10, 57);
	doc.text("_________________________________________________________________________________", 10, 65);
	doc.text("DATA ABSENSI", 20, 63);
	doc.text("PENDAPATAN", 80, 63);
	doc.text("POTONGAN", 140, 63);
	doc.setFontSize(8);
	doc.setFontType("normal");
	doc.text("Hari Masuk", 10, 73);
	doc.text("Hari Absen", 10, 78);
	doc.text("Sakit SKD", 10, 83);
	doc.text("Sakit Non SKD", 10, 88);
	doc.text("Ijin", 10, 93);
	doc.text("Ijin 2", 10, 98);
	doc.text("OT Hour", 10, 103);
	doc.text("Hari Cuti", 10, 108);
	doc.text("0", 50, 73);
	doc.text("0", 50, 78);
	doc.text("0", 50, 83);
	doc.text("0", 50, 88);
	doc.text("0", 50, 93);
	doc.text("0", 50, 98);
	doc.text("0", 50, 103);
	doc.text("0", 50, 108);
	doc.text("Lembur", 65, 73);
	doc.text("Gaji Pokok", 65, 78);
	doc.text("Tunjangan Jabatan", 65, 83);
	doc.text("Uang Makan", 65, 88);
	doc.text("Intensif Marketing", 65, 93);
	doc.text("Transport", 65, 98);
	doc.text("Tunjangan HP", 65, 103);
	doc.text("Bonus", 65, 108);
	doc.text("THR", 65, 113);
	doc.text("Uang Kerajinan", 65, 118);
	doc.text("0", 120, 73);
	doc.text("0", 120, 78);
	doc.text("0", 120, 83);
	doc.text("0", 120, 88);
	doc.text("0", 120, 93);
	doc.text("0", 120, 98);
	doc.text("0", 120, 103);
	doc.text("0", 120, 108);
	doc.text("0", 120, 113);
	doc.text("0", 120, 118);
	doc.text("____________________________________", 65, 123);
	doc.setFontStyle('bold');
	doc.text("Total Pendapatan", 65, 128);
	doc.text("0", 120, 128);
	doc.setFontStyle('normal');
	doc.text("Cicilan Pinjaman", 130, 73);
	doc.text("Potongan Jamsostek", 130, 78);
	doc.text("Potongan Absen", 130, 83);
	doc.text("Potongan Telat", 130, 88);
	doc.text("PPH21", 130, 93);
	doc.text("0", 175, 73);
	doc.text("0", 175, 78);
	doc.text("0", 175, 83);
	doc.text("0", 175, 88);
	doc.text("0", 175, 93);
	doc.text("____________________________________", 130, 123);
	doc.setFontStyle('bold');
	doc.text("Total Potongan", 130, 128);
	doc.text("0", 175, 128);
	doc.setFontSize(14);
	doc.text("Jumlah Gaji", 100, 140);
	doc.text("0", 150, 140);
	doc.save('a4.pdf');
}
