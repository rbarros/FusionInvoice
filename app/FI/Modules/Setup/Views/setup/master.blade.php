<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ trans('fi.setup') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <style type="text/css">
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
    }

    .install {
      max-width: 900px;
      padding: 19px 29px 29px;
      margin: 0 auto 20px;
      background-color: #fff;
      border: 1px solid #e5e5e5;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
      -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
      box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .form-install input[type="text"],
    .form-install input[type="password"] {
      font-size: 12px;
      height: auto;
      margin-bottom: 15px;
      padding: 7px 9px;
    }
    .form-install .checkbox, h2, h4 {
      margin-bottom: 10px;
    }

  </style>
  
  <script src="{{ asset('assets/js/libs/modernizr-2.0.6.js') }}"></script>
  <script src="{{ asset('assets/js/libs/jquery-1.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/libs/jquery-ui-1.10.3.min.js') }}"></script>
  <script src="{{ asset('assets/js/libs/bootstrap.min.js') }}"></script>

  @section('jscript')

  @show

</head>

<body>

  <div class="container">

    <div class="install">

      <h2>FusionInvoice</h2>
      <hr>

      @yield('content')

    </div>

  </div> <!-- /container -->

</body>
</html>