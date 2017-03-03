@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Kategori Arsip')

@section('breadcrumb', 'Kategori Arsip')

@section('content')
<div class="row">
  <div class="col-sm-3 col-md-3 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Direktori Arsip
      </div>
      <form id="form" action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="dataId" name="dataId"/>
        <div class="panel-body">
          <div class="row">
            <div class="sidebar-nav profile-sidebar">
            <div class="main-menu">
        			<ul class="nav">
        				<li id="akun">
        					<a class="chevron-accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#kategori1">
        					<i class="fa fa-user"></i>
        					Daftar Akun </a>
                  <ul id="kategori1" class="panel-collapse collapse">
                    <li>
                      <a href=""><i class="fa fa-group"></i> Admin</a>
                      <a href=""><i class="fa fa-graduation-cap"></i> Staff</a>
                    </li>
                  </ul>
        				</li>
              </ul>
            </div>
          </div>
        </div>
        </div>
        <div class="panel-footer" align="right">
          <input id="type" name="type" type="hidden"></input>
          <input id="level" name="level" type="hidden" value=""></input>
          <input id="_token" name="_token" type="hidden" value="{{csrf_token()}}"></input>
          <a class="btn btn-default add" tabindex="8"><i class="fa fa-plus"></i> Tambahkan Akun</a>
          <a id="updateBtn" name="updateBtn" type="button "class="btn btn-default pull-left" tabindex="9" disabled><i class="fa fa-edit"></i> Update Akun</a>
        </div>
      </form>
    </div>
  </div>
  <div class="col-sm-9 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
          Kategori Arsip
        </div>
        <div class="panel-body">
          <table class="table table-hover data-table">
              <thead>
                <tr role="row">
                  <th class="th-sm">No.</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th hidden></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1. </td>
                  <td>Tes</td>
                  <td>B</td>
                  <td>C</td>
                </tr>
            </table>
            <div class="container-fluid controls-button">
              <label id="admin-filecount" name="admin-filecount" class="filecount">0 admin terpilih </label> <a id="deleteBtn" name="deleteBtn" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"> Hapus</i></a>
            </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
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
        // }
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
    //$('#usersiklus').find("table").dataTable();
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
