<?php
?>
<div class="app-sidebar__inner">
	<ul class="vertical-nav-menu">
		<li>
		<li id="superadmin-menu" class="<?php echo ($current_menu == 'admin')?'mm-active':'' ?>">
			<a href="http://localhost/admin/admin">
				<i class="metismenu-icon pe-7s-users"></i>
				Super Admin
			</a>
		</li>
		<li id="employee-menu" class="<?php echo ($current_menu == 'user')?'mm-active':'' ?>">
			<a href="http://localhost/admin/user">
				<i class="metismenu-icon pe-7s-users"></i>
				Pencari Kerja
			</a>
		</li>
		<li id="employer-menu" class="<?php echo ($current_menu == 'employer')?'mm-active':'' ?>">
			<a href="http://localhost/admin/employer">
				<i class="metismenu-icon pe-7s-users"></i>
				Pemberi Kerja
			</a>
		</li>
		<li class="<?php echo ($current_menu == 'job')?'mm-active':'' ?>">
			<a href="http://localhost/admin/job">
				<i class="metismenu-icon pe-7s-portfolio"></i>
				Pekerjaan
			</a>
		</li>
		<li class="<?php echo ($current_menu == 'employee')?'mm-active':'' ?>">
			<a href="http://localhost/admin/employee">
				<i class="metismenu-icon pe-7s-id"></i>
				Karyawan
			</a>
		</li>
		<li class="<?php echo ($current_menu == 'attendance')?'mm-active':'' ?>">
			<a href="http://localhost/admin/attendance">
				<i class="metismenu-icon pe-7s-pin"></i>
				Absensi
			</a>
		</li>
		<li id="payroll-menu" class="<?php echo ($current_menu == 'payroll')?'mm-active':'' ?>">
			<a href="http://localhost/admin/payroll">
				<i class="metismenu-icon pe-7s-cash"></i>
				Payroll
			</a>
		</li>
		<li class="<?php echo ($current_menu == 'settings')?'mm-active':'' ?>">
			<a href="http://localhost/admin/settings">
				<i class="metismenu-icon pe-7s-settings"></i>
				Pengaturan
			</a>
		</li>
		<li class="<?php echo ($current_menu == 'logout')?'mm-active':'' ?>">
			<a href="http://localhost/admin/logout">
				<i class="metismenu-icon pe-7s-close-circle"></i>
				Keluar
			</a>
		</li>
	</ul>
</div>
