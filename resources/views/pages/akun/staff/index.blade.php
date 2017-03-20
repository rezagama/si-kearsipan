@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Akun Staff')

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  <li><a class="active" href="{{URL::route('admin.index')}}">Akun Staff</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-sm-4 col-md-4 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Tambah Staff
      </div>
      <form id="form" action="{{URL::route('staff.store')}}" method="POST" enctype="multipart/form-data">
        <div class="panel-body">
          <div class="container-fluid no-spacing">
            <div class="col-md-5 no-spacing">
              <img src="{{url('img/photo_placeholder.png')}}" class="thumbnail preview border-grey"/>
            </div>
            <div class="col-md-7 no-spacing">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-id-card-o"></i></span>
                <input id="nip" name="nip" type="text" data-parsley-type="number" maxlength="18" class="form-control" placeholder="NIP" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                <input id="email" name="email" type="email" maxlength="50" class="form-control" placeholder="Email" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
              </div>
            </div>
          </div>
          <div class="container-fluid no-spacing vertical-spacing-sm">
            <div class="col-md-7 no-spacing">
              <div class="input-group no-spacing">
                  <input id="filelabel" name="filelabel" type="text" class="form-control" value="Foto belum dipilih"readonly tabindex="7">
                  <label class="input-group-btn">
                      <span class="btn btn-default">
                          Pilih Foto <input name="foto" type="file" style="display: none;">
                      </span>
                  </label>
              </div>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="col-md-5 no-spacing">
                <button class="btn btn-default add pull-right" type="submit" tabindex="8"><i class="fa fa-plus"></i> Tambahkan Staff</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-sm-8 col-md-8 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Daftar Staff
        </div>
        <div class="panel-body">
            <div class="tab-content">
              <table class="table table-hover data-table">
                  <thead>
                    <tr role="row">
                      <th class="th-sm">No.</th>
                      <th></th>
                      <th class="th-md">Nama</th>
                      <th>NIP</th>
                      <th>Email</th>
                      <th hidden></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=1 ?>
                    @foreach($staff as $staff)
                      <tr id="row" role="row" data-id="{{$staff->id_user}}">
                        <td><div class="checkbox"> <input id="select" name="select" type="checkbox" value="{{$staff->id_user}}" class="inline"> {{$i++}}</div>.</td>
                        <td><img class="small-avatar" src="{{url($staff->foto)}}"</td>
                        <td>{{$staff->nama}}</td>
                        <td>{{$staff->nip}}</td>
                        <td>{{$staff->email}}</td>
                        <td>
                          <a href="{{URL::route('account.show', $staff->id_user)}}" type="button" class="btn btn-success btn-sm btn-sm-spacing"><i class="fa fa-chevron-right"></i></a>
                        </td>
                      </tr>
                    @endforeach
                </table>
                <div class="container-fluid controls-button" hidden>
                  <label id="count">0 akun terpilih </label> <a id="deleteBtn" name="deleteBtn" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"> Hapus</i></a>
                </div>
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
<script src="{{asset('js/parsley.js')}}"></script>
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

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection
