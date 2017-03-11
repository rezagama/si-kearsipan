<div id="sidebar-wrapper">
  <ul class="sidebar-nav profile-sidebar">
    <div class="navbar navbar-title">
      <a href="" class="nav-title"><i class="fa fa-shield"></i> <span>@if(Auth::user()->level == 0) Admin @else Staff
      @endif Panel</span></a>
    </div>
		<div class="avatar">
			<img src="{{url(Auth::user()->foto)}}" class="img-responsive thumbnail" alt="">
		</div>
		<div class="user-info">
			<div class="username">
				{{Auth::user()->nama}}
			</div>
			<div class="title">
				@if(Auth::user()->level == 0)
          Admin
        @else
          Staff
        @endif
			</div>
		</div>
		<div class="buttons">
			<button type="button" class="btn btn-success btn-sm">Profil</button>
			<button type="button" class="btn btn-danger btn-sm">Logout</button>
		</div>
		<div class="main-menu">
			<ul class="nav">
				<li id="dashboard">
					<a href="{{URL::route('dashboard.index')}}">
					<i class="fa fa-home"></i>
					Dashboard </a>
				</li>
				@if(Auth::user()->level == 0)
        <li id="akun">
					<a class="chevron-accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#sub-menu-akun">
					<i class="fa fa-user"></i>
					Daftar Akun </a>
          <ul id="sub-menu-akun" class="panel-collapse collapse">
            <li>
              <a href="{{URL::route('admin.index')}}"><i class="fa fa-group"></i> Admin</a>
              <a href="{{URL::route('staff.index')}}"><i class="fa fa-graduation-cap"></i> Staff</a>
            </li>
          </ul>
				</li>
        @endif
        <li id="arsip">
					<a class="chevron-accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#sub-menu-arsip">
					<i class="fa fa-book"></i>
					Daftar Arsip </a>
          <ul id="sub-menu-arsip" class="panel-collapse collapse">
            <li>
              <a href="{{URL::route('arsip.index')}}"><i class="fa fa-book"></i> Semua Arsip</a>
              <a href="{{URL::route('arsip.show', '584cd505aacbc75f09b0c10bc')}}"><i class="fa fa-book"></i> Arsip Aktif</a>
              <a href="{{URL::route('arsip.show', 'e562a38dfd73d2cb742583047')}}"><i class="fa fa-book"></i> Arsip Inaktif</a>
              <a href="{{URL::route('arsip.show', '56dfca5aebf1a93b0f7aa6401')}}"><i class="fa fa-book"></i> Arsip Statis</a>
              <a href="{{URL::route('arsip.show', '1b0a9c6c14433ffc492bfa4a2')}}"><i class="fa fa-book"></i> Arsip Dimusnahkan</a>
            </li>
          </ul>
				</li>
				@if(Auth::user()->level == 0)
        <li id="kategori">
          <a href="{{URL::route('kategori.index')}}">
          <i class="fa fa-list"></i>
          Kategori Arsip </a>
        </li>
        @endif
        <li id="statistik-arsip">
					<a href="{{URL::route('kategori.index')}}">
					<i class="fa fa-line-chart"></i>
					Statistik </a>
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
