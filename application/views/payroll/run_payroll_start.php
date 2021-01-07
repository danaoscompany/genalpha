<?php
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Jalankan Payroll</title>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
	<meta name="description" content="Tables are the backbone of almost all web applications.">
	<meta name="msapplication-tap-highlight" content="no">
	<script src="http://localhost/admin/js/jquery.js"></script>
	<script src="http://localhost/admin/js/global.js"></script>
	<script src="http://localhost/admin/js/jquery.redirect.js"></script>
	<script src="http://localhost/admin/js/moment.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
	<script src="http://localhost/admin/js/payroll_run_payroll_start.js"></script>
	<script src="http://localhost/admin/js/loading-bar.js"></script>
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
	<link href="http://localhost/admin/main.css" rel="stylesheet">
	<link href="http://localhost/admin/css/loading-bar.css" rel="stylesheet">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
	<div class="app-header header-shadow">
		<div class="app-header__logo">
			<img src="http://localhost/admin/assets/images/icon.png" width="30px" height="30px">
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
										<img width="42" height="42" class="rounded-circle" src="http://localhost/admin/images/profile_picture.png" alt="" style="border-radius: 21;">
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
				<img src="http://localhost/admin/assets/images/icon.png" width="30px" height="30px">
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
				<?php $this->load->view('sidebar', array('current_menu' => 'payroll')); ?>
			</div>
		</div>
		<div class="app-main__outer">
			<div class="app-main__inner">
				<div class="app-page-title">
					<div class="page-title-wrapper">
						<div class="page-title-heading">
							<div class="page-title-icon">
								<i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
								</i>
							</div>
							<div>Jalankan Payroll
							</div>
						</div>
						<div class="page-title-actions">
							<div class="d-inline-block dropdown">
								<button onclick="_export()" type="button"
										class="btn-shadow btn btn-info">
									Ekspor
								</button>
								<button onclick="_import()" type="button"
										class="btn-shadow btn btn-info">
									Impor
								</button>
								<button onclick="reset()" type="button"
										class="btn-shadow btn btn-info">
									Reset
								</button>
								<button onclick="runPayroll()" type="button"
										class="btn-shadow btn btn-info">
									Jalankan
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="main-card mb-3 card" style="width: 1000px;">
							<div class="card-body">
								<h5 class="card-title">Jalankan Payroll</h5>
								<table class="mb-0 table" style="margin-top: 12px;">
									<thead>
									<tr>
										<th>#</th>
										<th>Employee</th>
										<th>Tunjangan</th>
										<th>Lembur</th>
										<th>Penghasilan Tambahan</th>
										<th>Potongan Absen</th>
										<th>Total Bayar</th>
										<th>Ubah</th>
									</tr>
									</thead>
									<tbody id="employees">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirmLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="confirmLabel">Hapus Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="confirm-message" class="mb-0">Apakah Anda yakin ingin menghapus pengguna ini?</p>
			</div>
			<div class="modal-footer">
				<button id="confirm-no" type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
				<button id="confirm-yes" type="button" class="btn btn-primary" data-dismiss="modal" onclick="deleteUser()">Ya</button>
			</div>
		</div>
	</div>
</div>
<div id="edit-component" style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 2147483647;
	display: none; justify-content: center; align-items: center;">
	<div style="position: relative; width: 500px; height: 500px; overflow: auto; background-color: #ffffff; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		display: flex; flex-direction: column; border-radius: 4px;">
		<div style="color: #000000; font-size: 17px; margin-top: 12px; align-self: center;">Edit Komponent Payroll:</div>
		<div style="color: #000000; font-size: 15px; margin-left: 16px;">Nama:</div>
		<div id="user-name" style="color: #000000; font-size: 15px; margin-left: 16px; font-weight: bold;">Nama User</div>
		<div style="color: #000000; font-size: 15px; margin-left: 16px; margin-top: 8px;">Bonus:</div>
		<input name="bonus" id="bonus" placeholder="Masukkan bonus" type="text" class="form-control"
			   style="margin-left: 16px; margin-right: 16px; width: 468px;" value="0">
		<div style="color: #000000; font-size: 15px; margin-left: 16px; margin-top: 8px;">Overtime:</div>
		<input name="overtime" id="overtime" placeholder="Masukkan overtime" type="text" class="form-control"
			   style="margin-left: 16px; margin-right: 16px; width: 468px;" value="0">
		<div style="color: #000000; font-size: 15px; margin-left: 16px; margin-top: 8px;">Intensif:</div>
		<input name="intensive" id="intensive" placeholder="Masukkan intensif" type="text" class="form-control"
			   style="margin-left: 16px; margin-right: 16px; width: 468px;" value="0">
		<div style="color: #000000; font-size: 15px; margin-left: 16px; margin-top: 8px;">Komisi:</div>
		<input name="commission" id="commission" placeholder="Masukkan komisi" type="text" class="form-control"
			   style="margin-left: 16px; margin-right: 16px; width: 468px;" value="0">
		<div style="color: #000000; font-size: 15px; margin-left: 16px; margin-top: 8px;">Tunjangan Pulsa:</div>
		<input name="mobile-topup-allowance" id="mobile-topup-allowance" placeholder="Masukkan tunjangan pulsa" type="text" class="form-control"
			   style="margin-left: 16px; margin-right: 16px; width: 468px;" value="0">
		<div style="color: #000000; font-size: 15px; margin-left: 16px; margin-top: 8px;">Potongan Absensi:</div>
		<input name="absence-deduction" id="absence-deduction" placeholder="Masukkan potongan absensi" type="text" class="form-control"
			   style="margin-left: 16px; margin-right: 16px; width: 468px;" value="0">
		<button class="mb-2 mr-2 btn btn-info" style="width: 200px; align-self: center; margin-top: 12px; margin-bottom: 16px;"
				onclick="saveComponent()">Simpan</button>
		<p><br /></p>
		<ul id="employers" style="width: 100%; height: 400px; padding: 0; list-style-type: none; margin-top: 16px;
			overflow: auto;">
			<!--<li style="width: 100%; height: 100px; display: flex; flex-direction: column;">
				<div style="width: calc(100% - 16px); margin-left: 8px; margin-right: 8px; height: 1px;
					background-color: rgba(136, 136, 136, .3)" />
				<div style="width: 100%; display: flex; flex-direction: row; align-items: center; margin-top: 8px;">
					<img src="https://img.freepik.com/free-photo/cool-geometric-triangular-figure-neon-laser-light-great-backgrounds-wallpapers_181624-9331.jpg?size=626&ext=jpg"
						 width="50px" height="50px" style="margin-left: 8px; border-radius: 25px;">
					<div style="display: flex; flex-direction: row; justify-content: space-between;
							align-items: center; width: 100%;">
						<div style="display: flex; flex-direction: column; margin-left: 16px; margin-right: 16px;">
							<div style="color: #000000; font-size: 15px;">Nama Pencari Kerja</div>
							<div style="color: rgba(0, 0, 0, 0.4); font-size: 15px; margin-top: 0px;">
								emailpencarikerja@gmail.com
							</div>
						</div>
						<button class="mb-2 mr-2 btn btn-info">Pilih</button>
					</div>
				</div>
			</li>-->
		</ul>
		<div style="width: 50px; height:50px; position: absolute; top: 0; right: 0; display: flex; justify-content: center; align-items: center; cursor: pointer;"
			 onclick="$('#edit-component').fadeOut()">
			<i class="fa fa-times-circle fa-2x"></i>
		</div>
	</div>
</div>
<div id="loading-bar-container" style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 2147483647;
	display: none; justify-content: center; align-items: center;">
	<div style="position: relative; width: 500px; height: 200px; overflow: auto; background-color: #ffffff; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		display: flex; justify-content: center; align-items: center; flex-direction: column; border-radius: 4px;">
		<div id="loading-bar" class="ldBar" data-value="0">
		</div>
		<div style="color: #000000; font-size: 15px; margin-top: 32px;">Mengirim email ke <b id="send-email-user"></b></div>
	</div>
</div>
<input type="hidden" id="admin-id" value="<?php echo $adminID; ?>">
<input type="hidden" id="employees-data" value="<?php echo $employeesData; ?>">
<input type="hidden" id="date" value="<?php echo $date; ?>">
<input type="hidden" id="year" value="<?php echo $year; ?>">
<input type="hidden" id="month" value="<?php echo $month; ?>">
<script type="text/javascript" src="http://localhost/admin/assets/scripts/main.js"></script>
</body>
</html>
