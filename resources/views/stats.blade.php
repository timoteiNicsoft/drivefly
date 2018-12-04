@extends('layouts.app')
@section('header')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>
<script src="{{ asset('js/stats.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="template_search" style="display: none;">
       <table class="table">
           <tbody>
               <tr class="pointer" data-toggle="modal" data-target="#editReportModal" data-report-id="">
                   <td><span class="badge badge-secondary data__leavingDate_formatted">&nbsp;</span></td>
                   <td><span class="badge badge-secondary data__returnDate_formatted" >&nbsp;</span></td>
                   <td><span class="badge badge-secondary data__consolidator_name">&nbsp;</span> <span class="badge badge-primary data_product">&nbsp;</span></td>
                   <td><span class="badge badge-secondary data_refNum">&nbsp;</span></td>
                   <td><span class="badge badge-secondary data__airport_name">&nbsp;</span></td>
                   <td class="data__name">&nbsp;</td>
                   <td class="data_carReg">&nbsp;</td>
                   <td><span class="badge badge-pill data_color_selector_status data_status">&nbsp;</span></td>
               </tr>
           </tbody>
       </table>
   </div>
 <div class="row py-3">
   <div class="col-xs-6 col-sm-4 pb-2 pb-sm-0 d-flex justify-content-md-start">
     <div class="btn-group btn-group-toggle" data-toggle="buttons">
       <label class="btn btn-secondary active">
          <input type="radio" name="options" value="0" class="property_refresh_check property_name_service" checked> ALL
        </label>
        @if($services->count()>0)
        @foreach($services as $service)
        <label class="btn btn-secondary">
          <input type="radio" name="options" value="{{$service->id}}" class="property_refresh_check property_name_service" /> {{$service->acronym}}
        </label>
        @endforeach
        @else
        <label class="btn btn-secondary">
          <input type="radio" name="options" value="x" class="property_refresh_check property_name_service" /> No data
        </label>
        @endif
     </div>
   </div>

   <div class="col-xs-6 col-sm-4 pb-2 pb-sm-0 d-flex justify-content-md-center">
     <div class="btn-group btn-group-toggle" data-toggle="buttons">
       <label class="btn btn-secondary active">
          <input type="radio" name="options" value="0" class="property_refresh_check property_name_airport" checked> ALL
        </label>
        @if($airports->count()>0)
        @foreach($airports as $airport)
        <label class="btn btn-secondary">
          <input type="radio" name="options" value="{{$airport->id}}" class="property_refresh_check property_name_airport" /> {{$airport->acronym}}
        </label>
        @endforeach
        @else
        <label class="btn btn-secondary">
          <input type="radio" name="options" value="x" class="property_refresh_check property_name_service" /> No data
        </label>
        @endif

     </div>
   </div>

   <div class="col-xs-12 col-sm-4 pb-sm-0 d-flex justify-content-md-end">
     <div class="input-group date pr-2">
       <label class="btn m-0">From</label>
       <input type="text" class="form-control datetimepicker-input" id="datetimepicker_from" data-target="#datetimepicker_from" data-toggle="datetimepicker" />
     </div>
     <div class="input-group date pr-2">
       <label class="btn m-0">To</label>
       <input type="text" class="form-control datetimepicker-input" id="datetimepicker_to" data-target="#datetimepicker_to" data-toggle="datetimepicker">
     </div>
   </div>
 </div>
</div>

<div class="container-fluid pb-2 bg-light a_container">
 <div class="row">
   <div class="col py-3">
     <div id="chart_div" class="p-2 bg-white"></div>
   </div>
 </div>

 <div class="row">
   <div class="col pb-5">
     <table class="table table-drivefly borderless text-center">
       <tbody><tr>
         <th>Name</th>
         <th> 9th Aug</th>
         <th> 10th Aug</th>
         <th> 11th Aug</th>
         <th> 12th Aug</th>
         <th> 13th Aug</th>
         <th> 14th Aug</th>
         <th> 15th Aug</th>
         <th> 16th Aug</th>
         <th> 17th Aug</th>
         <th> 18th Aug</th>
         <th> 19th Aug</th>
         <th> 20th Aug</th>
         <th> 21st Aug</th>
         <th> 22nd Aug</th>
         <th> 23rd Aug</th>
       </tr>


       <tr>

         <td>DriveFly</td>

         <td>

           29
         </td>
         <td>

           14
         </td>
         <td>

           8
         </td>
         <td>

           21
         </td>
         <td>

           28
         </td>
         <td>

           13
         </td>
         <td>

           54
         </td>
         <td>

           34
         </td>
         <td>

           23
         </td>
         <td>

           24
         </td>
         <td>

           18
         </td>
         <td>

           29
         </td>
         <td>

           23
         </td>
         <td>

           49
         </td>
         <td>

           14
         </td>

       </tr>


     </tbody></table>
   </div>
 </div>
</div>

<div class="loader_container" style="display: none;">
 <div class="row mx-0 py-3 text-muted border-bottom">
  <div style="margin: 0 auto; color: #777" class="text-center">
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <div style="margin-bottom: 24px; font-size: 36px; line-height: 40px; font-weight: 900">One moment please</div>
    <p>We are looking for results using your criteria.</p>
  </div>
</div>
</div>

<div class="list_template" style="display: none;">
 <div class="row">
   <div class="col py-3">
     <div id="chart_div" class="p-2 bg-white"></div>
   </div>
 </div>

 <div class="row">
   <div class="col pb-5">
     <table class="table table-drivefly borderless text-center">
       <thead>
         <tr class="a_tr">
           <th>Name</th>
         </tr>
       </thead>
       <tbody class="a_tbody">
       </tbody>
     </table>
   </div>
 </div>
</div>
@include('modal')
  
@endsection
