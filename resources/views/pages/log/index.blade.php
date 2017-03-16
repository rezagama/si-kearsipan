@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Riwayat')

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  <li><a class="active" href="{{URL::route('log.index')}}">Riwayat</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-sm-6 col-md-3 col-xs-12">
    <div class="panel panel-default sidebar-stat">
      <div class="panel-heading">
        Statistik
      </div>
      <div class="container-fluid v-spacing">
        <div class="col-md-6" align="center">
          <label>Arsip</label>
          <h3 class="no-spacing">{{$arsip}}</h3>
          <p class="font-sm">aktifitas</p>
        </div>
        <div class="col-md-6" align="center">
          <label>Kategori</label>
          <h3 class="no-spacing">{{$kategori}}</h3>
          <p class="font-sm">aktifitas</p>
        </div>
      </div>
      <div class="container-fluid v-spacing">
        <div class="col-md-6" align="center">
          <label>Akun</label>
          <h3 class="no-spacing">{{$akun}}</h3>
          <p class="font-sm">aktifitas</p>
        </div>
        <div class="col-md-6" align="center">
          <label>Lain Lain</label>
          <h3 class="no-spacing">{{$lain}}</h3>
          <p class="font-sm">aktifitas</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Riwayat Aktifitas
        </div>
        <div class="panel-body">
            <div class="tab-content">
              <table class="table table-hover data-table">
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
                        @if($log->tipe == 0)
                          <p>{{$log->deskripsi}}</p>
                        @elseif($log->tipe == 1)
                          <?php $riwayat = DB::table('t_riwayat')->where('id_log', $log->id_log)->first(); ?>
                          <a href="{{URL::route('arsip.detail', $riwayat->id_arsip)}}">{{$log->deskripsi}}</a>
                        @elseif($log->tipe == 2)
                          <a href="{{URL::route('account.show', $log->url)}}">{{$log->deskripsi}}</a>
                          @elseif($log->tipe == 3)
                            <a href="{{URL::route('arsip.dokumen', $log->url)}}">{{$log->deskripsi}}</a>
                        @endif
                        <p class="no-spacing"><i class="fa fa-calendar"></i> {{Carbon::parse($log->created_at)->formatLocalized('%d, %B %Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($log->created_at))}}</p>
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
</div>
@endsection
@section('script')
<!-- Datatables-->
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
<script src="{{asset('js/script.js')}}"></script>
<!-- Datatables-->

<script>
  var handleDataTableButtons = function() {
      "use strict";
      0 !== $(".data-table").length && $(".data-table").DataTable({
        dom: "Bfrtip",
        buttons: [{
          extend: "copy",
          className: "btn-sm"
        }, {
          extend: "csv",
          className: "btn-sm"
        }, {
          extend: "excel",
          className: "btn-sm"
        },
        // {
        //   extend: "pdf",
        //   className: "btn-sm"
        // },
        {
          extend: "print",
          className: "btn-sm"
        }],
        responsive: !0
      })
    },
    TableManageButtons = function() {
      "use strict";
      return {
        init: function() {
          handleDataTableButtons()
        }
      }
    }();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    //$('#dokumensiklus').find("table").dataTable();
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
  TableManageButtons.init();
</script>
@endsection
