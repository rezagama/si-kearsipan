@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan')

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row">
  <div id="carousel" class="carousel slide pengumuman" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="{{url('img/background-pengumuman.jpg')}}" alt="pengumuman">
        <span class="text-pengumuman">
          <p class="judul-pengumuman no-spacing"><a href="{{URL::route('dashboard.index')}}" class="font-yellow cursor-pointer">Sistem Informasi Kearsipan Pemerintah Daerah Istimewa Yogyakarta</a></p>
          <div class="deskripsi-pengumuman">Berdasarkan Peraturan Pemerintah Republik Indonesia No. 28 Tahun 2012 Tentang PELAKSANAAN UNDANG-UNDANG NOMOR 43 TAHUN 2009 TENTANG KEARSIPAN</div>
        </span>
        <span class="transparent-bg"/>
      </div>
    </div>
  </div>
</div>
<div class="row v-spacing">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-user"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{$jumlah_admin}}</span>
        <span class="info-box-text">Admin</span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">{{$jumlah_staff}}</span>
        <span class="info-box-text">Staff</span>
      </div>
    </div>
  </div>
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-file-text"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{$jumlah_arsip}}</span>
        <span class="info-box-text">Arsip</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-folder"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{$jumlah_direktori}}</span>
        <span class="info-box-text">Direktori</span>
      </div>
    </div>
  </div>
</div>
<div class="row margin-spacing">
  <div class="col-md-7 col-sm-7 col-xs - 12">
    <div id="chart"></div>
  </div>
  <div class="col-md-5 col-sm-5 col-xs-12 margin-spacing-sm">
    <div class="panel-tile rank">
      <div class="panel-tile-title no-border">
        <h2> Arsip Memasuki Masa Retensi
        <div class="clearfix"></div>
      </div>
      <div class="panel-content">
        <table class="table table-hover data-table">
          <tbody>
            <?php $i=1; ?>
            @foreach($arsip_retensi as $arsip_retensi)
              <tr>
                <td align="center">{{$i++}}.</td>
                <td class="font-brown">
                  <p><i class="fa fa-file-text"></i> <a class="font-brown-bold" href="{{URL::route('arsip.detail', $arsip_retensi->id_arsip)}}"> {{$arsip_retensi->judul}}</a></p>
                  <p class="text-color"><i class="fa fa-calendar"></i> {{Helpers::formatLocalDate($arsip_retensi->jadwal_retensi, 'l, d M Y')}}</p>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row margin-spacing disable-side-margin">
  <div class="col-md-12col-sm-12 col-xs-12">
    <div class="panel-tile">
      <div class="panel-tile-title no-border">
        <h2>Aktifitas Terkini
        <div class="clearfix"></div>
      </div>
      <div class="panel-content">
        <table id="table" class="table table-hover data-table">
          <thead>
            <th>
              <td class="th-md"></td>
              <td></td>
            </th>
          </thead>
          <tbody>
            @foreach($log as $log)
            <tr>
              <td>
                <img src="{{url($log->foto)}}" class="avatar-xs" alt="{{$log->deskripsi}}">
              </td>
              <td>
                @if($log->tipe == 0 || $log->url == null)
                  <p>{{$log->deskripsi}}</p>
                @elseif($log->tipe == 1)
                  <?php
                    $riwayat = DB::table('t_riwayat')->where('id_log', $log->id_log)->first();
                  ?>
                  <a href="{{URL::route('arsip.detail', $riwayat->id_arsip)}}">{{$log->deskripsi}}</a>
                @elseif($log->tipe == 2)
                  <a href="{{URL::route('account.show', $log->url)}}">{{$log->deskripsi}}</a>
                @elseif($log->tipe == 3)
                  <a href="{{URL::route('arsip.dokumen', $log->url)}}">{{$log->deskripsi}}</a>
                @endif
                <p class="no-spacing"><i class="fa fa-calendar"></i> {{Helpers::formatLocalDate($log->created_at, 'd M Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($log->created_at))}}</p>
              </td>
              <td><i class="fa fa-clock-o"></i> {{Carbon::parse($log->created_at)->diffForHumans()}}</td>
            </tr>
            @endforeach
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
