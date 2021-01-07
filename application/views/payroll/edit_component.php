<?php
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Ubah Komponen</title>
	<meta name="viewport"
		  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
	<meta name="description" content="Tables are the backbone of almost all web applications.">
	<meta name="msapplication-tap-highlight" content="no">
	<script src="http://localhost/admin/js/jquery.js"></script>
	<script src="http://localhost/admin/js/global.js"></script>
	<script src="http://localhost/admin/js/jquery.redirect.js"></script>
	<script src="http://localhost/admin/js/moment.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
	<script src="http://localhost/admin/js/xlsx.full.min.js"></script>
	<script src="http://localhost/admin/js/payroll_edit_component.js"></script>
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
										<img width="42" height="42" class="rounded-circle"
											 src="http://localhost/admin/images/profile_picture.png" alt=""
											 style="border-radius: 21;">
										<i class="fa fa-angle-down ml-2 opacity-8"></i>
									</a>
									<div tabindex="-1" role="menu" aria-hidden="true"
										 class="dropdown-menu dropdown-menu-right">
										<button onclick="logout()" type="button" tabindex="0" class="dropdown-item">
											Logout
										</button>
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
							<div>Ubah Komponen
							</div>
						</div>
						<div class="page-title-actions">
							<div class="d-inline-block dropdown">
								<button onclick="add()" type="button"
										class="btn-shadow btn btn-info">
									Add
								</button>
								<button onclick="_import()" type="button"
										class="btn-shadow btn btn-info">
									Import
								</button>
								<button onclick="_export()" type="button"
										class="btn-shadow btn btn-info">
									Export
								</button>
								<button onclick="reset()" type="button"
										class="btn-shadow btn btn-info">
									Reset
								</button>
								<button onclick="_delete()" type="button"
										class="btn-shadow btn btn-info">
									Delete
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="main-card mb-3 card" style="width: 1000px;">
							<div class="card-body">
								<h5 class="card-title">UBAH KOMPONEN</h5>
								<div class="position-relative form-group"><label for="effective-date" class="">Tanggal
										Efektif</label>
									<input name="effective-date" id="effective-date"
										   placeholder="Masukkan tanggal efektif"
										   type="date" class="form-control">
								</div>
								<div class="position-relative form-group"><label for="component-name" class="">Nama
										Komponen</label>
									<select id="component-name" class="form-control-sm form-control">
									</select>
								</div>
								<div class="position-relative form-group"><label for="transaction-name" class="">Tipe
										Transaksi</label>
									<select id="transaction-type" class="form-control-sm form-control">
									</select>
								</div>
								<div class="position-relative form-group"><label for="description"
																				 class="">Deskripsi</label>
									<input name="description" id="description" placeholder="Masukkan deskripsi"
										   type="text" class="form-control">
								</div>
								<div class="position-relative form-check"><input name="check" id="backpay"
																				 type="checkbox"
																				 class="form-check-input"><label
											for="backpay" class="form-check-label">Tanggal backpay</label>
								</div>
								<div id="backpay-date-container" class="position-relative form-group" style="margin-top: 8px; display: none;">
									<input name="backpay-date" id="backpay-date" placeholder="Masukkan tanggal backpay"
										   type="date" class="form-control">
								</div>
								<table class="mb-0 table" style="margin-top: 16px;">
									<thead>
									<tr>
										<th>Pilih</th>
										<th>#</th>
										<th>ID</th>
										<th>Nama Lengkap</th>
										<th>Jml. Skrg.</th>
										<th>Jml. Baru</th>
										<th>Hapus</th>
									</tr>
									</thead>
									<tbody id="employees">
									<!--<tr>
										<th scope="row">1</th>
										<td>Mark</td>
										<td>Otto</td>
										<td>@mdo</td>
									</tr>-->
									</tbody>
								</table>
								<button class="mt-2 btn btn-primary" style="width: 100%;" onclick="save()">Simpan
								</button>
								<button class="mt-2 btn btn-danger" style="width: 100%;" onclick="cancel()">Batal
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="add-employee" style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 2147483647;
	display: none; justify-content: center; align-items: center;">
	<div style="position: relative; width: 800px; height: 500px; background-color: #ffffff; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		display: flex; flex-direction: column; border-radius: 4px; overflow: auto;">
		<h5 class="card-title"
			style="color: #444444; font-size: 17px; margin-top: 24px; align-self: center; font-weight: bold;">TAMBAH
			KARYAWAN</h5>
		<div style="color: #000000; font-size: 17px; margin-top: 12px; align-self: center;">Masukkan jumlah baru:</div>
		<div class="position-relative form-group" style="align-self: center;">
			<label for="amount" class=""></label>
			<input name="amount" id="amount" placeholder="Masukkan jumlah baru" type="text" class="form-control"
				   style="width: 300px; align-self: center;">
		</div>
		<div style="width: 100%; display: flex; justify-content: center;">
			<button class="mt-2 btn btn-info" style="width: 200px;" onclick="addComponent()">Tambah
			</button>
		</div>
		<table class="mb-0 table" style="margin-top: 24px;">
			<thead>
			<tr>
				<th style="width: 60px;">Pilih</th>
				<th style="width: 60px;">#</th>
				<th style="width: 60px;">ID</th>
				<th>Nama Lengkap</th>
			</tr>
			</thead>
			<tbody id="added-employees">
			<!--<tr>
				<th scope="row">1</th>
				<td>Mark</td>
				<td>Otto</td>
				<td>@mdo</td>
			</tr>-->
			</tbody>
		</table>
		<div style="width: 50px; height:50px; position: absolute; top: 0; right: 0; display: flex; justify-content: center; align-items: center; cursor: pointer;"
			 onclick="$('#add-employee').fadeOut()">
			<i class="fa fa-times-circle fa-2x"></i>
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
				<button id="confirm-yes" type="button" class="btn btn-primary" data-dismiss="modal"
						onclick="deleteUser()">Ya
				</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="admin-id" value="<?php echo $adminID; ?>">
<input type="hidden" id="id" value="<?php echo $id; ?>">
<input id="import-xls" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" style="width: 0; height: 0; visibility: hidden;">
<script type="text/javascript" src="http://localhost/admin/assets/scripts/main.js"></script>
</body>
</html>
