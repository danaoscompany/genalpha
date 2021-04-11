<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lihat Dokumen</title>
	<script src="http://genalpha.id/admin/js/jquery.js"></script>
	<script
			src="http://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js">
	</script>

	<style>
		#canvas_container {
			width: 100%;
			height: 100%;
			overflow: auto;
			background: #333;
			text-align: center;
			border: solid 3px;
		}
	</style>
</head>
<body>
<div id="my_pdf_viewer">
	<div id="canvas_container">
		<canvas id="pdf_renderer"></canvas>
	</div>
</div>

<script>
	var myState = {
		pdf: null,
		currentPage: 1,
		zoom: 1
	}
	$(document).ready(function() {
		let url = $("#pdf-url").val();
		let fileName = url.substr(url.lastIndexOf("/")+1, url.length);
		document.title = fileName;
		pdfjsLib.getDocument(url).then((pdf) => {

			myState.pdf = pdf;
			render();

		});

		function render() {
			myState.pdf.getPage(myState.currentPage).then((page) => {

				var canvas = document.getElementById("pdf_renderer");
				var ctx = canvas.getContext('2d');

				var viewport = page.getViewport(myState.zoom);

				canvas.width = viewport.width;
				canvas.height = viewport.height;

				page.render({
					canvasContext: ctx,
					viewport: viewport
				});
			});
		}

		document.getElementById('go_previous').addEventListener('click', (e) => {
			if(myState.pdf == null || myState.currentPage == 1)
				return;
			myState.currentPage -= 1;
			document.getElementById("current_page").value = myState.currentPage;
			render();
		});

		document.getElementById('go_next').addEventListener('click', (e) => {
			if(myState.pdf == null || myState.currentPage > myState.pdf._pdfInfo.numPages)
				return;
			myState.currentPage += 1;
			document.getElementById("current_page").value = myState.currentPage;
			render();
		});

		document.getElementById('current_page').addEventListener('keypress', (e) => {
			if(myState.pdf == null) return;

			// Get key code
			var code = (e.keyCode ? e.keyCode : e.which);

			// If key code matches that of the Enter key
			if(code == 13) {
				var desiredPage =
						document.getElementById('current_page').valueAsNumber;

				if(desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
					myState.currentPage = desiredPage;
					document.getElementById("current_page").value = desiredPage;
					render();
				}
			}
		});

		document.getElementById('zoom_in').addEventListener('click', (e) => {
			if(myState.pdf == null) return;
			myState.zoom += 0.5;
			render();
		});

		document.getElementById('zoom_out').addEventListener('click', (e) => {
			if(myState.pdf == null) return;
			myState.zoom -= 0.5;
			render();
		});
	});
</script>
<input type="hidden" id="pdf-url" value="<?php echo $pdfURL; ?>">
</body>
</html>
