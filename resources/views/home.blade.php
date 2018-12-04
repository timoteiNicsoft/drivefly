@extends('layouts.app')

@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>

<script src="{{ asset('js/home.js') }}"></script>
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
            @if($consolidator->acronym == 'NEW' || $consolidator->acronym == 'HD') @continue @endif
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

    <div class="col-xs-12 col-sm-4 pb-2 pb-sm-0 d-flex justify-content-md-end">
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
          <input type="radio" name="options" id="option3"> Latest
        </label>
        <div class="dropdown-menu" id="dd">
          <a class="dropdown-item" href="#">Today</a>
          <a class="dropdown-item" href="#">Tomorrow</a>
          <a class="dropdown-item" href="#">Today &amp; Tomorrow</a>
          <a class="dropdown-item" href="#">Xtra Payments Due</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid pb-2 bg-light list_container">
  <div class="row mx-0 py-3 text-muted border-bottom">
    <div class="col">
      When
    </div>
    <div class="col">
      Agent
    </div>
    <div class="col medium-column">
      Name
    </div>
    <div class="col">
      Airport
    </div>
    <div class="col small-column">
      Type
    </div>
    <div class="col">
      Ref
    </div>
    <div class="col">
      Arrival
    </div>
    <div class="col">
      Departure
    </div>
    <div class="col">
      Reg
    </div>
    <div class="col">
      Status
    </div>
    <div class="col small-column">
    </div>
  </div>

  <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#exampleModalCenter">
    <div class="col">
      <span class="span-tooltip" data-toggle="tooltip" data-placement="top" title="14 Aug 16:50">
        an hour ago
      </span>

    </div>
    <div class="col">
      <span class="badge badge-secondary">CHR</span>
      <span class="badge badge-primary">D</span>
    </div>
    <div class="col medium-column">
      Mr Jerome Nelson
    </div>
    <div class="col">
      <span class="badge badge-secondary">Birmingham</span>
    </div>
    <div class="col small-column">
      <span class="badge badge-secondary">MG</span>
    </div>
    <div class="col">
      <span class="badge badge-secondary">F8HX4T</span>
    </div>
    <div class="col">
      <span class="span-tooltip" data-toggle="tooltip" data-placement="top" title="9:30">
        14 Aug
      </span>
    </div>
    <div class="col">
      <span class="span-tooltip" data-toggle="tooltip" data-placement="top" title="21:30">
        22 Aug
      </span>
    </div>
    <div class="col">
      <span class="span-tooltip" data-toggle="tooltip" data-placement="top" title="Kia Sportage">
        GV64NYG
      </span>
    </div>
    <div class="col">
      <span class="badge badge-pill badge-success">OK</span>
    </div>
    <div class="col small-column">
      <span class="text-secondary">
        <i class="fas fa-piggy-bank"></i>
        <i class="fas fa-tag"></i>
      </span>
    </div>
  </div>

</div>


<div class="loader_container" style="display: none;">
  <div style="margin: 36px 0; color: #777; padding-top: 1rem;" class="text-center">
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <div style="margin-bottom: 24px; font-size: 36px; line-height: 40px; font-weight: 900">One moment please</div>
    <p>We are looking for results using your criteria.</p>
  </div>
</div>

<div class="list_header_container" style="display: none;">
  <div class="row mx-0 py-3 text-muted border-bottom">
    <div class="col">
      When
    </div>
    <div class="col">
      Agent
    </div>
    <div class="col medium-column">
      Name
    </div>
    <div class="col">
      Airport
    </div>
    <div class="col small-column">
      Type
    </div>
    <div class="col">
      Ref
    </div>
    <div class="col">
      Arrival
    </div>
    <div class="col">
      Departure
    </div>
    <div class="col">
      Reg
    </div>
    <div class="col">
      Status
    </div>
    <div class="col small-column">
    </div>
  </div>
</div>


<div class="list_item_template" style="display: none;">
  <div class="row mx-0 my-2 py-2 pointer" data-toggle="modal" data-target="#editReportModal" data-report-id="">
    <div class="col">
      <span class="span-tooltip data__created_relative" data-toggle="tooltip" data-placement="top" title="data__created_formatted">
      </span>
    </div>
    <div class="col">
      <span class="badge badge-secondary data_consolidatorName"></span>
      <span class="badge badge-primary data_product"></span>
    </div>
    <div class="col medium-column data__name">
    </div>
    <div class="col">
      <span class="badge badge-secondary data__airport_name"></span>
    </div>
    <div class="col small-column">
      <span class="badge badge-secondary data__type_acronym"></span>
    </div>
    <div class="col">
      <span class="badge badge-secondary data_refNum"></span>
    </div>
    <div class="col">
      <span class="span-tooltip data_color_selector_leavingDate data__leavingDate_formatted" data-toggle="tooltip" data-placement="top" title="data__leavingDate_additional"></span>
    </div>
    <div class="col">
      <span class="span-tooltip data__returnDate_formatted" data-toggle="tooltip" data-placement="top" title="data__returnDate_additional"></span>
    </div>
    <div class="col">
      <span class="span-tooltip data_carReg" data-toggle="tooltip" data-placement="top" title="data_carModel"></span>
    </div>
    <div class="col">
      <span class="badge badge-pill data_color_selector_status data_status"></span>
    </div>
    <div class="col small-column">
      <span class="text-secondary">
        <!--<span class="indata_xpayment" data-toggle="tooltip" data-placement="top"></span>-->
        <span class="indata_notes" data-toggle="tooltip" data-placement="top"></span>
      </span>
    </div>
  </div>
</div>
@include('modal')
@endsection
