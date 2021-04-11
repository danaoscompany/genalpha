<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Lihat Pekerjaan</title>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
	<meta name="description" content="Build whatever layout you need with our Architect framework.">
	<meta name="msapplication-tap-highlight" content="no">
	<script src="http://genalpha.id/admin/js/jquery.js"></script>
	<script src="http://genalpha.id/admin/js/jquery.redirect.js"></script>
	<script src="http://genalpha.id/admin/js/global.js"></script>
	<script src="http://genalpha.id/admin/js/view-job.js"></script>
	<style>
		@import url(https://fonts.googleapis.com/css?family=Roboto:400,400italic,600,600italic,700,700italic);
		body {
			font-family: 'Roboto';
			background-color: #f9f9f9;
		}

		.container{
			height:auto;
			width:580px;
			padding:0;
			margin:10px;
			border-radius:5px;
			box-shadow: 0 2px 3px rgba(0,0,0,.3)

		}

		header {
			position: relative;
		}

		.hide {
			display: none;
		}

		.tab-content {
			padding:25px;
		}

		#material-tabs {
			position: relative;
			display: block;
			padding:0;
			border-bottom: 1px solid #e0e0e0;
		}

		#material-tabs>a {
			position: relative;
			display:inline-block;
			text-decoration: none;
			padding: 22px;
			text-transform: uppercase;
			font-size: 14px;
			font-weight: 600;
			color: #424f5a;
			text-align: center;
			outline:;
		}

		#material-tabs>a.active {
			font-weight: 700;
			outline:none;
		}

		#material-tabs>a:not(.active):hover {
			background-color: inherit;
			color: #7c848a;
		}

		@media only screen and (max-width: 520px) {
			.nav-tabs#material-tabs>li>a {
				font-size: 11px;
			}
		}

		.yellow-bar {
			position: absolute;
			z-index: 10;
			bottom: 0;
			height: 3px;
			background: #458CFF;
			display: block;
			left: 0;
			transition: left .2s ease;
			-webkit-transition: left .2s ease;
		}

		#tab1-tab.active ~ span.yellow-bar {
			left: 0;
			width: 110px;
		}

		#tab2-tab.active ~ span.yellow-bar {
			left: 115px;
			width: 72px;
		}

		#tab3-tab.active ~ span.yellow-bar {
			left: 192px;
			width: 115px;
		}

		#tab4-tab.active ~ span.yellow-bar {
			left:392px;
			width: 163px;
		}
	</style>
	<script>
		$(document).ready(function() {
			$('#material-tabs').each(function() {

				var $active, $content, $links = $(this).find('a');

				$active = $($links[0]);
				$active.addClass('active');

				$content = $($active[0].hash);

				$links.not($active).each(function() {
					$(this.hash).hide();
				});

				$(this).on('click', 'a', function(e) {

					$active.removeClass('active');
					$content.hide();

					$active = $(this);
					$content = $(this.hash);

					$active.addClass('active');
					$content.show();

					e.preventDefault();
				});
			});
		});
	</script>
	<!--
	=========================================================
	* ArchitectUI HTML Theme Dashboard - v1.0.0
	=========================================================
	* Product Page: https://dashboardpack.com
	* Copyright 2019 DashboardPack (https://dashboardpack.com)
	* Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
	=========================================================
	* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
	-->
	<link href="http://genalpha.id/admin/main.css" rel="stylesheet">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
	<div class="app-header header-shadow">
		<div class="app-header__logo">
			<img src="http://genalpha.id/admin/assets/images/icon.png" width="30px" height="30px">
			<div class="header__pane ml-auto">
				<div>
					<button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
							data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
					</button>
				</div>
			</div>
		</div>
		<div class="app-header__mobile-menu">
			<div>
				<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
				</button>
			</div>
		</div>
		<div class="app-header__menu">
                <span>
                    <button type="button"
							class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
		</div>
		<div class="app-header__content">
			<?php $this->load->view('header-top'); ?>
			<div class="app-header-right">
				<div class="header-btn-lg pr-0">
					<div class="widget-content p-0">
						<div class="widget-content-wrapper">
							<div class="widget-content-left">
								<div class="btn-group">
									<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
									   class="p-0 btn">
										<img width="42" height="42" class="rounded-circle" src="http://genalpha.id/admin/images/profile_picture.png" alt="" style="border-radius: 21;">
										<i class="fa fa-angle-down ml-2 opacity-8"></i>
									</a>
									<div tabindex="-1" role="menu" aria-hidden="true"
										 class="dropdown-menu dropdown-menu-right">
										<button onclick="logout()" type="button" tabindex="0" class="dropdown-item">Logout</button>
									</div>
								</div>
							</div>
							<div class="widget-content-left  ml-3 header-user-info">
								<div id="admin-name" class="widget-heading">
								</div>
								<div id="admin-email" class="widget-subheading">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-main">
		<div class="app-sidebar sidebar-shadow">
			<div class="app-header__logo">
				<img src="http://genalpha.id/admin/assets/images/icon.png" width="30px" height="30px">
				<div class="header__pane ml-auto">
					<div>
						<button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
								data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
						</button>
					</div>
				</div>
			</div>
			<div class="app-header__mobile-menu">
				<div>
					<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
					</button>
				</div>
			</div>
			<div class="app-header__menu">
                        <span>
                            <button type="button"
									class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
			</div>
			<div class="scrollbar-sidebar">
				<?php $this->load->view('sidebar', array('current_menu' => 'job')); ?>
			</div>
		</div>
		<div class="app-main__outer">
			<div class="app-main__inner">
				<div class="app-page-title">
					<div class="page-title-wrapper">
						<div class="page-title-heading">
							<div class="page-title-icon">
								<i class="pe-7s-graph text-success">
								</i>
							</div>
							<div>Lihat Pekerjaan
							</div>
						</div>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
						<div class="main-card mb-3 card">
							<div class="card-body"><h5 class="card-title">LIHAT PEKERJAAN</h5>
								<div class="container">
									<header>
										<div id="material-tabs">
											<a id="tab1-tab" href="#tab1" class="active">TENTANG</a>
											<a id="tab2-tab" href="#tab2">FOTO</a>
											<a id="tab3-tab" href="#tab3">DOKUMEN</a>
											<span class="yellow-bar"></span>
										</div>
									</header>
									<div class="tab-content">
										<div id="tab1">
											<div class="position-relative form-group">
												<label for="job-title" class="">Nama</label>
												<input name="job-title" id="job-title" placeholder="Nama pekerjaan"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="company-name" class="">Perusahaan</label>
												<input name="company-name" id="company-name" placeholder="Nama perusahaan"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="working-start" class="">Tanggal Mulai Bekerja</label>
												<input name="working-start" id="working-start" placeholder="Tanggal mulai"
													   type="date" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="working-end" class="">Tanggal Akhir Bekerja</label>
												<input name="working-end" id="working-start" placeholder="Tanggal akhir"
													   type="date" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="specialization" class="">Spesialisasi</label>
												<input name="specialization" id="specialization" placeholder="Spesialisasi"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="work-field" class="">Bidang Pekerjaan</label>
												<input name="work-field" id="work-field" placeholder="Bidang pekerjaan"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="country" class="">Negara</label>
												<input name="country" id="country" placeholder="Negara"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="industry" class="">Industri</label>
												<input name="industry" id="industry" placeholder="Industri"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="position" class="">Posisi</label>
												<input name="position" id="position" placeholder="Posisi"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="salary" class="">Gaji Diharapkan</label>
												<input name="salary" id="salary" placeholder="Gaji diharapkan"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="salary-currency" class="">Mata Uang</label>
												<input name="salary-currency" id="salary-currency" placeholder="Mata uang"
													   type="text" class="form-control">
											</div>
											<div class="position-relative form-group">
												<label for="salary-currency" class="">Deskripsi Pekerjaan</label>
												<div id="work-description"></div>
											</div>
										</div>
										<div id="tab2">
											<div id="photos"></div>
										</div>
										<div id="tab3">
											<div id="documents">
												<!--<div style="width: calc(100%-16px); height: 70px; margin-left: 8px;
													margin-right: 8px; margin-top: 8px; margin-bottom: 8px;
													background-color: #ffffff; border-radius: 4px;
													box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
													display: flex; flex-direction: row; align-items: center;
													justify-content: space-between; padding-left: 24px;
													padding-right: 24px;">
													<div style="display: flex; flex-direction: row;
														align-items: center;">
														<img src="http://genalpha.id/admin/systemdata/pdf.png"
															 width="30px" height="30px">
														<div style="color: #000000; font-size: 15px; margin-left: 16px;">
															This is document title
														</div>
													</div>
													<div style="display: flex; flex-direction: row;
														align-items: center;">
														<button class="mt-2 btn btn-info"
																onclick="viewDocument()">Lihat
														</button>
														<button class="mt-2 btn btn-info" style="margin-left: 8px;"
																onclick="download()">Download
														</button>
													</div>
												</div>-->
											</div>
										</div>
									</div>
								</div>
								<!-- end container -->
								<div style="width: 100%; display: flex; flex-direction: row;">
									<button class="mt-2 btn btn-danger" style="width: 100%;" onclick="cancelEditing()">Kembali
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
						<div class="main-card mb-3 card">
							<div class="card-body"><h5 class="card-title">Grid</h5>
								<form class="">
									<div class="position-relative row form-group"><label for="exampleEmail"
																						 class="col-sm-2 col-form-label">Email</label>
										<div class="col-sm-10"><input name="email" id="exampleEmail"
																	  placeholder="with a placeholder" type="email"
																	  class="form-control"></div>
									</div>
									<div class="position-relative row form-group"><label for="examplePassword"
																						 class="col-sm-2 col-form-label">Password</label>
										<div class="col-sm-10"><input name="password" id="examplePassword"
																	  placeholder="password placeholder" type="password"
																	  class="form-control"></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleSelect"
																						 class="col-sm-2 col-form-label">Select</label>
										<div class="col-sm-10"><select name="select" id="exampleSelect"
																	   class="form-control"></select></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleSelectMulti"
																						 class="col-sm-2 col-form-label">Select
											Multiple</label>
										<div class="col-sm-10"><select multiple="" name="selectMulti"
																	   id="exampleSelectMulti"
																	   class="form-control"></select></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleText"
																						 class="col-sm-2 col-form-label">Text
											Area</label>
										<div class="col-sm-10"><textarea name="text" id="exampleText"
																		 class="form-control"></textarea></div>
									</div>
									<div class="position-relative row form-group"><label for="exampleFile"
																						 class="col-sm-2 col-form-label">File</label>
										<div class="col-sm-10"><input name="file" id="exampleFile" type="file"
																	  class="form-control-file">
											<small class="form-text text-muted">This is some placeholder block-level
												help text for the above input. It's a bit lighter and easily wraps to a
												new line.</small>
										</div>
									</div>
									<fieldset class="position-relative row form-group">
										<legend class="col-form-label col-sm-2">Radio Buttons</legend>
										<div class="col-sm-10">
											<div class="position-relative form-check"><label
													class="form-check-label"><input name="radio2" type="radio"
																					class="form-check-input"> Option one
													is this and that—be sure to include why it's great</label></div>
											<div class="position-relative form-check"><label
													class="form-check-label"><input name="radio2" type="radio"
																					class="form-check-input"> Option two
													can be something else and selecting it will deselect option
													one</label></div>
											<div class="position-relative form-check disabled"><label
													class="form-check-label"><input name="radio2" disabled=""
																					type="radio"
																					class="form-check-input"> Option
													three is disabled</label></div>
										</div>
									</fieldset>
									<div class="position-relative row form-group"><label for="checkbox2"
																						 class="col-sm-2 col-form-label">Checkbox</label>
										<div class="col-sm-10">
											<div class="position-relative form-check"><label
													class="form-check-label"><input id="checkbox2" type="checkbox"
																					class="form-check-input"> Check me
													out</label></div>
										</div>
									</div>
									<div class="position-relative row form-check">
										<div class="col-sm-10 offset-sm-2">
											<button class="btn btn-secondary">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input id="admin-id" type="hidden" value="<?php echo $adminID; ?>">
<input id="job-id" type="hidden" value="<?php echo $jobID; ?>">
<script type="text/javascript" src="http://genalpha.id/admin/assets/scripts/main.js"></script>
</body>
</html>
