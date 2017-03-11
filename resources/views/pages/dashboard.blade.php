@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan')

@section('content')
<div class="row">
  <div id="carousel" class="carousel slide pengumuman" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carousel" data-slide-to="0" class="active"></li>
      <li data-target="#carousel" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="{{url('img/tugu_jogja.png')}}" alt="Jogja">
        <span class="text-pengumuman"><p class="judul-pengumuman">Pengumuman A</p>

        <p class="deskripsi-pengumuman">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p></span>
        <span class="transparent-bg"/>
      </div>

      <div class="item">
        <img src="{{url('img/bank_indonesia.jpg')}}" alt="BI">
        <span class="text-pengumuman"><p class="judul-pengumuman">Pengumuman B</p>

        <p class="deskripsi-pengumuman">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p></span>
        <span class="transparent-bg"/>
      </div>
    </div>
  </div>
</div>
<div class="row v-spacing">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-gray"><i class="fa fa-user"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">5</span>
        <span class="info-box-text">Admin</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-gray"><i class="fa fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">7</span>
        <span class="info-box-text">Staff</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-gray"><i class="fa fa-lock"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">55x</span>
        <span class="info-box-text">Login</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-gray"><i class="fa fa-calendar"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">12/15/2016</span>
        <span class="info-box-text">Terakhir Login</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<div class="row margin-spacing">
  <div class="col-md-7 col-sm-7 col-xs - 12">
    <div id="chart"></div>
  </div>
  <div class="col-md-5 col-sm-5 col-xs - 12 margin-spacing-sm">
    <div class="panel-tile rank">
      <div class="panel-tile-title">
        <h2> Arsip Teratas
        <div class="clearfix"></div>
      </div>
      <div class="panel-content">

        <table class="table table-hover data-table">
          <thead>
            <tr>
              <th class="th-center">No.</th>
              <th>Judul Arsip</th>
              <th class="th-center">Diakses</th>
              <th class="th-center">Diunduh<th>
            </tr>
          </thead>
          <tbody class>
            <tr>
              <td align="center">1.</td>
              <td><i class="fa fa-book"></i> Arsip A</td>
              <td align="center">197 kali</td>
              <td align="center">97 kali</td>
            </tr>
            <tr>
              <td align="center">2.</td>
              <td><i class="fa fa-book"></i> Arsip B</td>
              <td align="center">102 kali</td>
              <td align="center">67 kali</td>
            </tr>
            <tr>
              <td align="center">3.</td>
              <td><i class="fa fa-book"></i> Arsip C</td>
              <td align="center">92 kali</td>
              <td align="center">45 kali</td>
            </tr>
            <tr>
              <td align="center">4.</td>
              <td><i class="fa fa-book"></i> Arsip D</td>
              <td align="center">72 kali</td>
              <td align="center">27 kali</td>
            </tr>
            <tr>
              <td align="center">5.</td>
              <td><i class="fa fa-book"></i> Arsip E</td>
              <td align="center">52 kali</td>
              <td align="center">17 kali</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
<div class="row margin-spacing disable-side-margin">
  <div class="col-md - 12 col-sm - 12 col-xs - 12">
    <div class="panel-tile">
      <div class="panel-tile-title no-border">
        <h2>Aktifitas Terkini
        <div class="clearfix"></div>
      </div>
      <div class="panel-content">
        <table class="table table-hover">
          <tbody>
            <tr>
              <td><img src="http://orig02.deviantart.net/f49e/f/2010/346/d/7/this_is_me_by_hace_studio-d34q588.png" class="avatar-xs" alt=""></td>
              <td><i class="fa fa-calendar"></i> 12/03/2017</td>
              <td>Reza menambahkan kategori dalam Sistem Informasi Kearsipan</td>
              <td><i class="fa fa-clock-o"></i> 5 menit yg lalu</td>
              <td></td>
            </tr>
            <tr>
              <td><img src="https://shortcut-test2.s3.amazonaws.com/uploads/user_image/attachment/2351/default_ProfKranc_Cartoon_profile.png" class="avatar-xs" alt=""></td>
              <td><i class="fa fa-calendar"></i> 12/03/2017</td>
              <td>Andi menambahkan arsip statis</td>
              <td><i class="fa fa-clock-o"></i> 8 menit yg lalu</td>
              <td></td>
            </tr>
            <tr>
              <td><img src="http://3.bp.blogspot.com/-FQQJB2TCab8/UAJDAnRdYjI/AAAAAAAAAUY/Gtn_izXBiSc/s1600/Gambar+Kartun+jilbab.jpg" class="avatar-xs" alt=""></td>
              <td><i class="fa fa-calendar"></i> 12/03/2017</td>
              <td>Dina menambahkan arsip inaktif</td>
              <td><i class="fa fa-clock-o"></i> 10 menit yg lalu</td>
              <td></td>
            </tr>
            <tr>
              <td><img src="http://orig11.deviantart.net/50f1/f/2013/285/f/0/cartoon_cayby__new_avatar_profile__by_c_e_studio-d6q7znc.png" class="avatar-xs" alt=""></td>
              <td><i class="fa fa-calendar"></i> 12/03/2017</td>
              <td>Banu menambahkan arsip aktif</td>
              <td><i class="fa fa-clock-o"></i> 15 menit yg lalu</td>
              <td></td>
            </tr>
            <tr>
              <td><img src="https://s-media-cache-ak0.pinimg.com/236x/c2/32/ca/c232caba75d18121bfffb5dc081d7c9d.jpg" class="avatar-xs" alt=""></td>
              <td><i class="fa fa-calendar"></i> 12/03/2017</td>
              <td>Rara mengubah arsip inaktif menjadi arsip dimusnahkan</td>
              <td><i class="fa fa-clock-o"></i> 1 hari yg lalu</td>
              <td></td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
  <script src="{{url('js/highcharts.js')}}"></script>
  <script src="{{url('js/dashboard.js')}}"></script>
@endsection
