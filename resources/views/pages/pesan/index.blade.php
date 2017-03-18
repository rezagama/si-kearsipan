@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / '.$title)

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if($title == 'Pesan Masuk')
    <li><a class="active" href="{{URL::route('pesan.masuk')}}">{{$title}}</a></li>
  @else
    <li><a class="active" href="{{URL::route('pesan.keluar')}}">{{$title}}</a></li>
  @endif
</ol>
<div class="row v-spacing">
  <div class="col-sm-6 col-md-3 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Menu
      </div>
      <div class="list-group">
        @if($title == 'Pesan Masuk')
        <a href="{{URL::route('pesan.masuk')}}" class="list-group-item active"><i class="fa fa-envelope"></i> Pesan Masuk <span class="badge">{{$pesanmasuk}}</span></a>
        <a href="{{URL::route('pesan.keluar')}}" class="list-group-item"><i class="fa fa-envelope-open"></i> Pesan Terkirim<span class="badge">{{$pesankeluar}}</span></a>
        @else
        <a href="{{URL::route('pesan.masuk')}}" class="list-group-item"><i class="fa fa-envelope"></i> Pesan Masuk <span class="badge">{{$pesanmasuk}}</span></a>
        <a href="{{URL::route('pesan.keluar')}}" class="list-group-item active"><i class="fa fa-envelope-open"></i> Pesan Terkirim<span class="badge">{{$pesankeluar}}</span></a>
        @endif
        <a href="{{URL::route('pesan.compose')}}" class="list-group-item"><i class="fa fa-pencil"></i> Tulis Pesan</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                {{$title}}
        </div>
        <div class="panel-body">
            <div class="tab-content">
              <table class="table table-hover data-table">
                  <thead>
                    <tr>
                      <td class="th-avatar"></td>
                      <td class="table-lg"></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pesan as $pesan)
                    <tr>
                      <td align="center">
                        <img src="{{url($pesan->foto)}}" class="avatar-lg" alt="{{$pesan->judul_pesan}}">
                      </td>
                      <td>
                          @if($pesan->status == 0 && $pesan->id_pengirim != Auth::user()->id_user)
                            <p class="no-spacing"><a href="{{URL::route('pesan.show', $pesan->id_pesan)}}" class="font-brown-bold">{{$pesan->judul_pesan}}</a>
                              @if($pesan->id_pengirim == Auth::user()->id_user)
                              <form action="{{URL::route('pesan.delete', $pesan->id_pesan)}}" class="pull-right" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus pesan ini?');">
                                <input type="hidden" name="_method" value="DELETE"></input>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                                <button type="submit" class="btn btn-danger btn-sm btn-sm-spacing"><i class="fa fa-trash"></i></button>
                              </form>
                              @endif
                            </p>
                          @else
                            <div class="container-fluid no-spacing">
                              <p class="no-spacing"><a href="{{URL::route('pesan.show', $pesan->id_pesan)}}" class="font-brown pull-left">{{$pesan->judul_pesan}}</a></p>
                              @if($pesan->id_pengirim == Auth::user()->id_user)
                              <form id="form" action="{{URL::route('pesan.delete', $pesan->id_pesan)}}" class="pull-right" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus pesan ini?');">
                                <input type="hidden" name="_method" value="DELETE"></input>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                                <a href="javascript: submitform()" class="font-red cursor-pointer"><i class="fa fa-trash"></i> Hapus</a>
                              </form>
                              @endif
                            </div>
                          @endif
                          <p class="no-spacing"><i class="fa fa-calendar"></i> {{Carbon::parse($pesan->created_at)->formatLocalized('%d, %B %Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($pesan->created_at))}} <i class="fa fa-user"></i> <a class="font-brown" href="{{URL::route('account.show', $pesan->id_user)}}">{{$pesan->nama}}</a></p>
                          <p align="justify">{!! Helpers::trimText($pesan->isi_pesan, 30) !!}</p>
                      </td>
                      <td align="center"><i class="fa fa-clock-o"></i> {{Carbon::parse($pesan->created_at)->diffForHumans()}}</td>
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
    function submitform(){
      $("#form").submit();
    }
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
