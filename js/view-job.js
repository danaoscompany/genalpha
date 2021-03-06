var jobID = 0;
var photos = [];
var documents = [];

$(document).ready(function() {
	jobID = $("#job-id").val().trim();
	getJobInfo();
	getJobPhotos();
	getJobDocuments();
});

function getJobInfo() {
	let fd = new FormData();
	fd.append("job_id", jobID);
	fetch(PHP_URL+"/admin/get_job_by_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			let job = JSON.parse(response);
			$("#job-title").val(job['job_title']);
			$("#company-name").val(job['company_name']);
			$("#working-start").val(job['working_start']);
			$("#working-end").val(job['working_end']);
			$("#specialization").val(job['specialization']);
			$("#work-field").val(job['work_field']);
			$("#country").val(job['country']);
			$("#industry").val(job['industry']);
			$("#position").val(job['position']);
			$("#salary").val(job['salary']);
			$("#salary-currency").val(job['salary_currency']);
			$("#work-description").html(job['work_description']);
		});
}

function getJobPhotos() {
	$("#photos").find("*").remove();
	photos = [];
	let fd = new FormData();
	fd.append("job_id", jobID);
	fetch(PHP_URL+"/admin/get_job_photos_by_job_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			photos = JSON.parse(response);
			for (let i=0; i<photos.length; i+=5) {
				var row = "";
				row += "<div class='row' style='margin-top: 16px;'>";
				if (i < photos.length) {
					row += "<div class='col' style=\"position: relative; opacity: " + photos[i]['opacity'] + ";\">" +
						"   <img src='" + USERDATA_URL + photos[i]['path'] + "' width='130px' height='130px' style=\"\">" +
						"   <div class='image-hover' style=\"cursor: pointer; position: absolute; top: 0; left: 16; width: 130px; height: 130px; display: flex; justify-content: center; align-items: center;\"" +
						"		onclick='viewPhoto("+i+")'>" +
						"   </div>" +
						"</div>";
				}
				if ((i+1) < photos.length) {
					row += "<div class='col' style=\"position: relative; opacity: " + photos[i+1]['opacity'] + ";\">" +
						"   <img src='" + USERDATA_URL + photos[i]['path'] + "' width='130px' height='130px' style=\"\">" +
						"   <div class='image-hover' style=\"cursor: pointer; position: absolute; top: 0; left: 16; width: 130px; height: 130px; display: flex; justify-content: center; align-items: center;\">" +
						"   </div>" +
						"</div>";
				}
				if ((i+2) < photos.length) {
					row += "<div class='col' style=\"position: relative; opacity: " + photos[i+2]['opacity'] + ";\">" +
						"   <img src='" + USERDATA_URL + photos[i]['path'] + "' width='130px' height='130px' style=\"\">" +
						"   <div class='image-hover' style=\"cursor: pointer; position: absolute; top: 0; left: 16; width: 130px; height: 130px; display: flex; justify-content: center; align-items: center;\">" +
						"   </div>" +
						"</div>";
				}
				if ((i+3) < photos.length) {
					row += "<div class='col' style=\"position: relative; opacity: " + photos[i+3]['opacity'] + ";\">" +
						"   <img src='" + USERDATA_URL + photos[i]['path'] + "' width='130px' height='130px' style=\"\">" +
						"   <div class='image-hover' style=\"cursor: pointer; position: absolute; top: 0; left: 16; width: 130px; height: 130px; display: flex; justify-content: center; align-items: center;\">" +
						"   </div>" +
						"</div>";
				}
				if ((i+4) < photos.length) {
					row += "<div class='col' style=\"position: relative; opacity: " + photos[i+4]['opacity'] + ";\">" +
						"   <img src='" + USERDATA_URL + photos[i]['path'] + "' width='130px' height='130px' style=\"\">" +
						"   <div class='image-hover' style=\"cursor: pointer; position: absolute; top: 0; left: 16; width: 130px; height: 130px; display: flex; justify-content: center; align-items: center;\">" +
						"   </div>" +
						"</div>";
				}
				row += "</div>";
				$("#photos").append(row);
			}
		});
}

function getJobDocuments() {
	$("#documents").find("*").remove();
	documents = [];
	let fd = new FormData();
	fd.append("job_id", jobID);
	fetch(PHP_URL+"/admin/get_job_documents_by_job_id", {
		method: 'POST',
		body: fd
	})
		.then(response => response.text())
		.then(response => {
			documents = JSON.parse(response);
			for (let i=0; i<documents.length; i+=5) {
				let document = documents[i];
				$("#documents").append("<div style=\"width: calc(100%-16px); height: 70px; margin-left: 8px;\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\tmargin-right: 8px; margin-top: 8px; margin-bottom: 8px;\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\tbackground-color: #ffffff; border-radius: 4px;\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\tbox-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\tdisplay: flex; flex-direction: row; align-items: center;\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\tjustify-content: space-between; padding-left: 24px;\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\tpadding-right: 24px;\">\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t<div style=\"display: flex; flex-direction: row;\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\talign-items: center;\">\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t<img src=\"http://localhost/admin/systemdata/pdf.png\"\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t width=\"30px\" height=\"30px\">\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div style=\"color: #000000; font-size: 15px; margin-left: 16px;\">\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t"+document['title']+"\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t<div style=\"display: flex; flex-direction: row;\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\talign-items: center;\">\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t<button class=\"mt-2 btn btn-info\"\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tonclick=\"viewDocument("+i+")\">Lihat\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t</button>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t<button class=\"mt-2 btn btn-info\" style=\"margin-left: 8px;\"\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tonclick=\"downloadDocument("+i+")\">Download\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t\t</button>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n" +
					"\t\t\t\t\t\t\t\t\t\t\t\t</div>");
			}
		});
}

function viewPhoto(index) {
	let photo = photos[index];
	$.redirect(PHP_URL+"/photo/view", {
		url: USERDATA_URL+photo['path']
	}, 'POST', '_blank');
}

function viewDocument(index) {
	let document = documents[index];
	$.redirect(PHP_URL+"/pdf/view", {
		url: USERDATA_URL+document['path']
	}, 'POST', '_blank');
}

function downloadDocument(index) {
	let document = documents[index];
	downloadFile(USERDATA_URL+document['path']);
}
