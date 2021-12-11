<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>
  <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/ico/favicon.ico')}}">

  {{-- Include core + vendor Styles --}}
  @include('panels.styles')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column navbar-static footer-static light-layout" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-framework="laravel">

  <!-- BEGIN: Header-->
  @yield('header')
  <!-- END: Header-->

  <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div id="content-wrapper" class="content-wrapper">
      <div class="content-header row">
      </div>
      <div id="main-content" class="content-body">
        @yield('content')
      </div>
    </div>
  </div>
  <!-- END: Content-->

  @include('panels.scripts')

</body>
<!-- END: Body-->

</html>