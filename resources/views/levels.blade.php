@extends('layouts.app')
@section('header')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>

<script src="{{ asset('js/levels.js') }}"></script>
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

        <label class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
          <input type="radio" name="options" class="px-5"> &nbsp;
        </label>
        <div class="dropdown-menu">
          <a href="#" class="dropdown-item property_refresh_select property_name_consolidator property_value_0">All</a>
          <div class="dropdown-divider"></div>

          @if($consolidators->count()>0)
          @foreach($consolidators as $consolidator)
          <a href="#" class="dropdown-item property_refresh_select property_name_consolidator property_value_{{$consolidator->id}}">{{$consolidator->acronym}}</a>
          @endforeach
          @else
          <label class="btn btn-secondary">
            <input type="radio" name="options" value="x" class="property_refresh_check property_name_service" /> No data
          </label>
          @endif

                </div>
            </div>
        </div>

        <div class="col-sm-4 pb-2 pb-sm-0 d-flex justify-content-md-end">
            <input type="hidden" id="datetimepickerHidden" class="datetimepicker-input"  />
            <div class="btn-group btn-group-toggle">
                <button id="date_back" class="btn btn-secondary"><i class="fas fa-step-backward"></i></button>
                <button id="date_date" class="btn btn-secondary active" data-toggle="datetimepicker" data-target="#datetimepickerHidden">Today</i></button>
                <button id="date_forw" class="btn btn-secondary"><i class="fas fa-step-forward"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pb-2 bg-light a_container">
  <div class="row">
    <div class="col py-3">
      <div id="chart_div"></div>
    </div>
  </div>

  <div class="row">
    <div class="col pb-5">
      <table class="table table-drivefly borderless text-center">
        <thead>
          <tr>
            <th class="text-left">Date</th>
            <th>Start</th>
            <th>In</th>
            <th>Out</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left">29th Aug</td>
            <td>4897</td>
            <td>355</td>
            <td>607</td>
          </tr>
        </tbody>
      </table>
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
      <div id="chart_div"></div>
    </div>
  </div>

  <div class="row">
    <div class="col pb-5">
      <table class="table table-drivefly borderless text-center">
        <thead>
          <tr>
            <th class="text-left">Date</th>
            <th>Start</th>
            <th>In</th>
            <th>Out</th>
          </tr>
        </thead>
        <tbody class="a_tbody">
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="list_item_template" style="display: none;">
  <table>
    <tbody>
          <tr class="a_tr">
            <td class="text-left data__date_formatted">29th Aug</td>
            <td class="data__start"></td>
            <td class="data__in"></td>
            <td class="data__out"></td>
          </tr>
    </tbody>
  </table>
</div>
@include('modal')
@endsection
