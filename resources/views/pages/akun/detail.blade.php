@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Akun / '. $user->nama)

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if($user->level == 0)
    <li><a href="{{URL::route('admin.index')}}">Akun Admin</a></li>
  @else
    <li><a href="{{URL::route('staff.index')}}">Akun Staff</a></li>
  @endif
  <li><a class="active" href="{{URL::route('account.show', $user->id_user)}}">{{$user->nama}}</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Profil <a href="{{URL::route('account.edit', $user->id_user)}}" class="btn btn-warning btn-sm btn-panel-heading pull-right"><i class="fa fa-edit"></i></a>
      </div>
      <div class="panel-body">
        <div class="container-fluid no-spacing">
          <div class="col-md-5 col-sm-5 col-xs-12 no-spacing">
            <img src="{{url($user->foto)}}" class="thumbnail preview"/>
          </div>
          <div class="col-md-7 col-sm-7 col-xs-12 no-spacing">
            <label>NIP</label>
            <p>{{$user->nip}}</p>
            <label>Nama</label>
            <p>{{$user->nama}}</p>
            <label>Email</label>
            <p>{{$user->email}}</p>
          </div>
        </div>
        <hr/>
        <div class="container-fluid no-spacing">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>No. HP</label>
            <p>
              @if($user->no_hp == '')
                -
              @else
                {{$user->no_hp}}
              @endif
            </p>
            <label>Tanggal Lahir</label>
            <p>{{Helpers::formatLocalDate($user->tgl_lahir, 'd M Y')}}</p>
            <label>Jenis Kelamin</label>
            <p>
              @if($user->jenis_kelamin == 0)
                Laki-laki
              @else
                Perempuan
              @endif
            </p>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Alamat</label>
            <p>
              @if($user->alamat == '')
                -
              @else
                {{$user->alamat}}
              @endif
            </p>
            <label>Status</label>
            <p>
              @if($user->level == 0)
                <span class="label label-primary inline">Admin</span>
              @else
                <span class="label label-info inline">Staff</span>
              @endif
              @if($user->status == 0)
                <span class="label label-warning inline">Belum Aktif</span>
              @elseif($user->status == 1)
                <span class="label label-success inline">Aktif</span>
              @else
                <span class="label label-danger inline">Nonaktif</span>
              @endif
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Aktifitas
        </div>
        <div class="panel-body">
            <div class="tab-content">
              <table class="table table-hover data-table">
                  <thead>
                    <tr>
                      <td></td>
                      <td class="th-md"></td>
                      <td class="th-time"></td>
                    </tr>
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
                        <p class="no-spacing"><i class="fa fa-calendar"></i> {{Helpers::formatLocalDate($log->created_at, 'l, d M Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($log->created_at))}}</p>
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
        "oLanguage": {
          "sEmptyTable": "Belum ada aktifitas."
        },
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
