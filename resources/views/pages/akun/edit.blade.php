@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Akun / '. $user->nama. ' / Edit')

@section('css')
  <link href="{{url('css/bootstrap-datepicker.css')}}" rel="stylesheet"/>
  <link href="{{url('css/picker/picker-default.css')}}" rel="stylesheet"/>
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if($user->level == 0)
    <li><a href="{{URL::route('admin.index')}}">Akun Admin</a></li>
  @else
    <li><a href="{{URL::route('staff.index')}}">Akun Staff</a></li>
  @endif
  <li><a href="{{URL::route('account.show', $user->id_user)}}">{{$user->nama}}</a></li>
  <li><a class="active" href="{{URL::route('account.edit', $user->id_user)}}">Edit</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-sm-4 col-md-4 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Edit Profil
      </div>
      <form id="form" action="{{URL::route('account.update', $user->id_user)}}" method="POST" enctype="multipart/form-data">
        <div class="panel-body">
          <div class="container-fluid no-spacing">
            <div class="col-md-5 no-spacing">
              <img src="{{url($user->foto)}}" class="thumbnail preview border-grey"/>
            </div>
            <div class="col-md-7 no-spacing">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama" value="{{$user->nama}}" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-id-card-o"></i></span>
                <input id="nip" name="nip" type="text" data-parsley-type="number" maxlength="18" class="form-control" placeholder="NIP" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="2" value="{{$user->nip}}">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                <input id="email" name="email" type="email" maxlength="50" class="form-control" placeholder="Email" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="3" value="{{$user->email}}">
              </div>
            </div>
          </div>
          <div class="container-fluid no-spacing vertical-spacing-sm">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-venus-mars"></i></span>
                <div class="left-margin-sm vertical-spacing-xs inline">
                  @if($user->jenis_kelamin == 0)
                  <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="0" tabindex="5" checked>Laki-laki</label>
                  <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="1" tabindex="6">Perempuan</label>
                  @else
                  <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="0" tabindex="5">Laki-laki</label>
                  <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="1" tabindex="6" checked>Perempuan</label>
                  @endif
                </div>
            </div>
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input id="tgl_lahir" name="tgl_lahir" type="text" class="form-control" placeholder="Tanggal Lahir" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="7" value="{{date('d/m/Y', strtotime($user->tgl_lahir))}}">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone"></i></span>
              <input id="no_hp" name="no_hp" type="text" data-parsley-type="number" maxlength="18" class="form-control" placeholder="No. HP" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="8" value="{{$user->no_hp}}">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
              <input id="password" name="password" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" tabindex="9">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock-alt"></i></span>
              <input id="ulang_password" name="ulang_password" type="password" class="form-control" placeholder="Ulang Password" aria-describedby="basic-addon1" tabindex="10">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <textarea id="alamat" name="alamat" class="form-control custom-control" rows="5" style="resize:none" placeholder="Alamat ..." tabindex="10">{{$user->alamat}}</textarea>
            </div>
            <div class="col-md-7 no-spacing">
              <div class="input-group">
                  <input id="filelabel" name="filelabel" type="text" class="form-control" value="Foto belum dipilih"readonly>
                  <label class="input-group-btn">
                      <span class="btn btn-default">
                          Pilih Foto <input name="foto" type="file" style="display: none;">
                      </span>
                  </label>
              </div>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="col-md-5 no-spacing">
                <div class="input-group fit-width" align="right">
                  <button class="btn btn-default add" type="submit" tabindex="11"><i class="fa fa-check"></i> Simpan</a>
                </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-sm-8 col-md-8 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Aktifitas
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
<script src="{{asset('js/parsley.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<script src="{{asset('js/picker.js')}}"></script>
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

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection
