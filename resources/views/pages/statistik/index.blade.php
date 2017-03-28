@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Statistik')

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  <li><a class="active" href="{{URL::route('statistik.index')}}">Statistik</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-folder"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{$arsip_aktif}}</span>
        <span class="info-box-text">Arsip Aktif</span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-folder"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">{{$arsip_inaktif}}</span>
        <span class="info-box-text">Arsip Inaktif</span>
      </div>
    </div>
  </div>
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-folder"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{$arsip_statis}}</span>
        <span class="info-box-text">Arsip Statis</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs - 12">
    <div class="info-box">
      <span class="info-box-icon bg-brown"><i class="fa fa-folder"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{$arsip_musnah}}</span>
        <span class="info-box-text">Arsip Dimusnahkan</span>
      </div>
    </div>
  </div>
</div>
<div class="row margin-spacing">
  <div class="col-md-12">
    <div id="pertambahan">
    </div>
  </div>
</div>
<div class="row margin-spacing">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="panel-tile rank">
      <div class="panel-tile-title no-border">
        <h2> Arsip Teratas Berdasarkan Akses
        <div class="clearfix"></div>
      </div>
      <div class="panel-content">
        <table class="table table-hover data-table">
          <tbody>
            <?php $i=1; ?>
            @foreach($arsip_akses as $arsip_akses)
              <tr>
                <td align="center">{{$i++}}.</td>
                <td class="font-brown">
                  <p><i class="fa fa-file-text"></i> <a class="font-brown-bold" href="{{URL::route('arsip.detail', $arsip_akses->id_arsip)}}"> {{$arsip_akses->judul}}</a></p>
                  <p class="text-color"><i class="fa fa-eye"></i> {{$arsip_akses->jumlah_akses}}x akses</p>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-6 col-xs-12 margin-spacing-sm">
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
<div class="row margin-spacing">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="panel-tile rank">
      <div class="panel-tile-title no-border">
        <h2> Arsip Teratas Berdasarkan Unduhan
        <div class="clearfix"></div>
      </div>
      <div class="panel-content">
        <table class="table table-hover data-table">
          <tbody>
            <?php $i=1; ?>
            @foreach($arsip_unduh as $arsip_unduh)
              <tr>
                <td align="center">{{$i++}}.</td>
                <td class="font-brown">
                  <p><i class="fa fa-file-text"></i> <a class="font-brown-bold" href="{{URL::route('arsip.detail', $arsip_unduh->id_arsip)}}"> {{$arsip_unduh->judul}}</a></p>
                  <p class="text-color"><i class="fa fa-cloud-download"></i> {{$arsip_unduh->jumlah_unduh}}x unduhan</p>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-6 col-xs-12 margin-spacing-sm">
    <div class="panel-tile rank">
      <div class="panel-tile-title no-border">
        <h2> Arsip Teratas Berdasarkan Jumlah Cetak
        <div class="clearfix"></div>
      </div>
      <div class="panel-content">
        <table class="table table-hover data-table">
          <tbody>
            <?php $i=1; ?>
            @foreach($arsip_cetak as $arsip_cetak)
              <tr>
                <td align="center">{{$i++}}.</td>
                <td class="font-brown">
                  <p><i class="fa fa-file-text"></i> <a class="font-brown-bold" href="{{URL::route('arsip.detail', $arsip_cetak->id_arsip)}}"> {{$arsip_cetak->judul}}</a></p>
                  <p class="text-color"><i class="fa fa-print"></i> {{$arsip_cetak->jumlah_cetak}}x cetak</p>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row margin-spacing">
  <div class="col-md-6">
    <div id="jumlah"></div>
  </div>
  <div class="col-md-6">
    <div id="grafik-kategori"></div>
  </div>
</div>
<div class="row margin-spacing disable-side-margin">
  <div class="col-md-12 col-sm-12 col-xs-12">
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
  <script src="{{url('js/statistik.js')}}"></script>
  <script src="{{asset('js/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('js/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('js/datatables/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('js/datatables/buttons.bootstrap.min.js')}}"></script>
  <script src="{{asset('js/datatables/tableconfig.min.js')}}"></script>
  <script src="{{asset('js/datatables/pdfmake.min.js')}}"></script>
  <script src="{{asset('js/datatables/buttons.html5.min.js')}}"></script>
  <script src="{{asset('js/datatables/buttons.print.min.js')}}"></script>
  <script src="{{asset('js/datatables/dataTables.keyTable.min.js')}}"></script>
  <script src="{{asset('js/datatables/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('js/datatables/responsive.bootstrap.min.js')}}"></script>
  <script src="{{asset('js/datatables/dataTables.scroller.min.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#table').dataTable();
      $('#datatable-keytable').DataTable({
        keys: true
      });
      $('#datatable-responsive').DataTable();
      $('#datatable-scroller').DataTable({
        ajax: "js/datatables/json/scroller-demo.json",
        deferRender: true,
        scrollY: 380,
        scrollCollapse: true,
        scroller: true
      });
      var table = $('#datatable-fixed-header').DataTable({
        fixedHeader: false
      });
    });
  </script>
@endsection
