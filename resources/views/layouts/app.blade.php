<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
 <title>DriveFly</title>

 <meta charset="utf-8">
 <meta http-equiv="x-ua-compatible" content="ie=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta name="csrf-token" content="{{ csrf_token() }}" />
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
 <link rel="stylesheet" type="text/css" href="{{ asset('css/dropzone.css') }}" >
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

 <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
 <script src="{{ asset('js/general.js') }}"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.js"></script>
 @yield('header')
 @yield('javascript')
</head>
<body>
  <div class="alertZone">
  </div>
  <div class="alertTemplate">
    <div class="alert alert-success" style="display: none; margin-bottom: 0;">
      <strong>Successfully </strong> handled!
      <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <nav class="navbar navbar-expand-md bg-light navbar-light shadow-sm px-sm-0">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="{{ asset('build/images/df-logo.png') }}" width="100px;" />
          <!--<i class="fa d-inline fa-lg fa-plane" style="color: blue"></i>-->
          <strong> {{ Auth::user()->name }}</strong>
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbar2SupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item mx-2 active">
              <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item mx-2">
             <a class="nav-link" href="{{ route('daily') }}">Daily</a>
           </li>
           <li class="nav-item mx-2">
             <a class="nav-link" href="{{ route('stats') }}">Stats</a>
           </li>
           <li class="nav-item mx-2">
             <a class="nav-link" href="{{ route('levels') }}">Levels</a>
           </li>
           <li class="nav-item mx-2">
             <a class="nav-link" href="{{ route('monthly') }}">Monthly</a>
           </li>
           <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Other</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
             <a class="dropdown-item" href="{{route('daily_without_terminal')}}">Daily without terminal</a>
             <a class="dropdown-item" href="{{ route('prices') }}">Prices</a>
             <a class="dropdown-item" href="{{ route('products') }}">Products</a>
             <a class="dropdown-item" href="{{ route('extra_payments') }}">Extra payments</a>
             <a class="dropdown-item" href="{{route('alerts')}}">Alerts</a>
             <a class="dropdown-item" href="{{route('logs')}}">Logs</a>
           </div>
         </li>
       </ul>
       <div class="d-inline-flex">
         <form class="form-inline my-2 my-lg-0 mx-2" onsubmit="return false;">
            <input type="hidden" id="search_filter" value="all">
           <div class="input-group">
             <input class="form-control data_search" type="text" placeholder="Search">
             <div class="input-group-append">
                <button class="btn btn-outline-secondary trigger_search">Search</button>
                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="text_selected_filter">All</span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" id="filter_search">
                  <a class="dropdown-item" href="javascript:void(0);" data-val="all">All</a>
                  <a class="dropdown-item" href="javascript:void(0);" data-val="carReg">only in <strong>Car Reg</strong></a>
                  <a class="dropdown-item" href="javascript:void(0);" data-val="ref">only in <strong>Reference</strong></a>
                  <a class="dropdown-item" href="javascript:void(0);" data-val="name">only in <strong>Name</strong></a>
                </div>
             </div>
           </div>
         </form>
         <ul class="navbar-nav">
           <li class="nav-item">
             <a class="nav-link" href="add.php"><i class="fa d-inline fa-lg fa-plus-circle"></i></a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="{{ route('printer-settings') }}"><i class="fa d-inline fa-lg fa-cog"></i></a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="logout.php"><i class="fa d-inline fa-lg fa-sign-out-alt"></i></a>
           </li>
         </ul>
       </div>
     </div>
   </nav>
   <div id="search-result" class="panel panel-default a_search_container" style="display: none;">
    <div class="panel-heading">
      <button type="button" class="close a_search_close"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
      <h3 class="panel-title text-center">Search Result</h3>
    </div>
    <div class="panel-body" style="background: rgba(241, 189, 189, 0.75);">
      <small>You can search by: id, reference, name, mobile and vehicle registration </small>
      <hr>
      <div>
        <table class="table a_table_search">
          <tbody>
            <tr class="pointer">
              <td><span class="label label-default">...</span></td>
              <td><span class="label label-default">...</span></td>
              <td><span class="label label-default">...</span><span class="label label-info">...</span></td>
              <td><span class="label label-default">...</span></td>
              <td><span class="label label-default">...</span></td>
              <td>...</td>
              <td>...</td>
              <td><span class="label label-success">...</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</div>
@yield('content')
</body>
</html>
