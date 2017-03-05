<!DOCTYPE html>
<html>
  <head>
  <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link href="{{url('css/bootstrap.css')}}" rel="stylesheet"/>
  <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet"/>
  <link href="{{url('css/style.css')}}" rel="stylesheet"/>
  @yield('css')
  </head>

  <body>
    <!--@include('partials.header')-->
    <div id="wrapper">
      @include('partials.sidebar')
      <div id="page-content-wrapper">
          <div class="page-content">
              <div class="container-fluid">
                  @if(Session::has('error'))
                  <div class="alert alert-warning fade in alert-dismissable v-spacing">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                      {{Session::get('error')}}
                  </div>
                  @endif
                  @if(Session::has('info'))
                  <div class="alert alert-info fade in alert-dismissable v-spacing">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                      {{Session::get('info')}}
                  </div>
                  @endif
                  @yield('content')
              </div>
          </div>
      </div>
    </div>
    <script src="{{url('js/jquery-1.12.3.min.js')}}"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>
    @yield('script')
    <script src="{{url('js/script.js')}}"></script>
  </body>
</html>
