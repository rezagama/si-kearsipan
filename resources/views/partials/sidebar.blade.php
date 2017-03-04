<div id="sidebar-wrapper">
  <ul class="sidebar-nav profile-sidebar">
    <div class="navbar navbar-title">
      <a href="" class="nav-title"><i class="fa fa-shield"></i> <span>Admin Panel</span></a>
    </div>
		<div class="avatar">
			<img src="https://cdnil0.fiverrcdn.com/deliveries/458463/medium/create-cartoon-caricatures_ws_1364550258.png?1364550258" class="img-responsive" alt="">
		</div>
		<div class="user-info">
			<div class="username">
				Reza
			</div>
			<div class="title">
				Admin
			</div>
		</div>
		<div class="buttons">
			<button type="button" class="btn btn-success btn-sm">Profil</button>
			<button type="button" class="btn btn-danger btn-sm">Logout</button>
		</div>
		<div class="main-menu">
			<ul class="nav">
				<li id="dashboard" class="active">
					<a href="">
					<i class="fa fa-home"></i>
					Dashboard </a>
				</li>
				<li id="akun">
					<a class="chevron-accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#sub-menu-akun">
					<i class="fa fa-user"></i>
					Daftar Akun </a>
          <ul id="sub-menu-akun" class="panel-collapse collapse">
            <li>
              <a href=""><i class="fa fa-group"></i> Admin</a>
              <a href=""><i class="fa fa-graduation-cap"></i> Staff</a>
            </li>
          </ul>
				</li>
        <li id="arsip">
					<a class="chevron-accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#sub-menu-arsip">
					<i class="fa fa-book"></i>
					Daftar Arsip </a>
          <ul id="sub-menu-arsip" class="panel-collapse collapse">
            <li>
              <a href=""><i class="fa fa-book"></i> Arsip Aktif</a>
              <a href="#"><i class="fa fa-book"></i> Arsip Inaktif</a>
              <a href=""><i class="fa fa-book"></i> Arsip Statis</a>
              <a href="#"><i class="fa fa-book"></i> Arsip Dimusnahkan</a>
            </li>
          </ul>
				</li>
				<li id="kategori-arsip">
					<a href="{{URL::route('kategori.index')}}">
					<i class="fa fa-list"></i>
					Kategori Arsip </a>
				</li>
        <li id="statistik">
					<a class="chevron-accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#sub-menu-statistik">
					<i class="fa fa-line-chart"></i>
					Statistik </a>
          <ul id="sub-menu-statistik" class="panel-collapse collapse">
            <li>
              <a href=""><i class="fa fa-line-chart"></i> Arsip Aktif</a>
              <a href=""><i class="fa fa-line-chart"></i> Arsip Inaktif</a>
              <a href=""><i class="fa fa-line-chart"></i> Arsip Statis</a>
              <a href=""><i class="fa fa-line-chart"></i> Arsip Dimusnahkan</a>
            </li>
          </ul>
				</li>
        <li id="riwayat">
					<a href="">
					<i class="fa fa-calendar"></i>
					Riwayat </a>
				</li>
        <li id="pesan">
					<a href="">
					<i class="fa fa-envelope"></i>
					Pesan </a>
				</li>
        <li id="logout">
					<a href="{{URL::route('user.logout')}}">
					<i class="fa fa-power-off"></i>
					Logout </a>
				</li>
			</ul>
		</div>
	</ul>
</div>
