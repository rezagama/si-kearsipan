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
      <!-- Page content -->
      <div id="page-content-wrapper">
          <div class="content-header">
            <a id="menu-toggle" href="#" class="btn btn-default"><i class="fa fa-th-list"></i></a>
            <span class="nav-breadcrumb">@yield('breadcrumb')</span>
          </div>
          <!-- Keep all page content within the page-content inset div! -->
          <div class="page-content">
              <div class="container-fluid">
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
