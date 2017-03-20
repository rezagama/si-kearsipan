<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Informasi Kearsipan / Pengumuman / .{{$pengumuman->judul_pengumuman}}</title>

        <link rel="stylesheet" href="{{url('css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{url('css/style.css')}}">
        <link rel="stylesheet" href="{{url('css/login.css')}}">
        <link rel="shortcut icon" href="{{url('favicon.ico')}}">
    </head>
    <body>
        <div class="top-content">
            <div class="inner-bg">
                <div class="container" align="left">
                  <ol class="breadcrumb v-spacing">
                    <i class="fa fa-sitemap breadcrumb-ic"></i>
                    <li><a href="{{URL::route('login.index')}}">Beranda</a></li>
                    <li><a href="{{URL::route('pengumuman.list')}}">Pengumuman</a></li>
                    <li><a class="active" href="{{URL::route('pengumuman.post', $pengumuman->id_pengumuman)}}">{{$pengumuman->judul_pengumuman}}</a></li>
                  </ol>
                  <div class="row v-spacing">
                    <div class="col-sm-6 col-md-3 col-xs-12">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          Menu
                        </div>
                        <div class="list-group">
                          <a href="{{URL::route('login.index')}}" class="list-group-item"><i class="fa fa-home"></i> Beranda</a>
                          <a href="{{URL::route('pengumuman.list')}}" class="list-group-item"><i class="fa fa-newspaper-o"></i> Pengumuman</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-9 col-xs-12">
                      <div class="panel with-nav-tabs panel-default">
                          <div class="panel-heading">
                            {{$pengumuman->judul_pengumuman}}
                          </div>
                          <div class="panel-body">
                            <p><i class="fa fa-calendar"></i> {{Helpers::formatLocalDate($pengumuman->created_at, 'l, d M Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($pengumuman->created_at))}} <i class="fa fa-user"></i> <span class="font-brown">{{$pengumuman->nama}}</span></p>
                            <p align="justify">{!! $pengumuman->isi_pengumuman !!}</p>
                            <p align="right"><i class="fa fa-clock-o"></i> {{Carbon::parse($pengumuman->created_at)->diffForHumans()}}</p>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <script src="{{url('js/jquery-1.12.3.min.js')}}"></script>
        <script src="{{url('js/bootstrap.min.js')}}"></script>
    </body>
</html>
