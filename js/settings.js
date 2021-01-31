$(document).ready(function() {
	$("#dev-mode").on("change", function() {
		if ($("#dev-mode").prop("checked")) {
			$("#dev-mode-text").html("Ya");
		} else {
			$("#dev-mode-text").html("Tidak");
		}
	});
	$.ajax({
		type: 'GET',
		url: PHP_URL+"/admin/get_settings",
		dataType: 'text',
		cache: false,
		success: function(response) {
			var settings = JSON.parse(response);
			$("#share").val(settings['share_text']);
			$("#dev-mode").prop("checked", parseInt(settings['dev_mode'])==1);
			$("#dev-mode-text").html(parseInt(settings['dev_mode'])==1?"Ya":"Tidak");
		}
	});
});

function save() {
	var shareText = $("#share").val().trim();
	var devMode = $("#dev-mode").is(":checked");
	let fd = new FormData();
	fd.append("share_text", shareText);
	fd.append("dev_mode", devMode?1:0);
	$.ajax({
		type: 'POST',
		url: PHP_URL+"/admin/update_settings",
		data: fd,
		processData: false,
		contentType: false,
		cache: false,
		success: function(response) {
			window.location.href = "http://genalpha.id/admin/settings";
		}
	});
}

function cancel() {
	if (confirm("Apakah Anda yakin ingin membatalkan perubahan?")) {
		window.location.href='http://genalpha.id/admin/settings';
	}
}
