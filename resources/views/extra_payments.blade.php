@extends('layouts.app')

@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>

<script src="{{ asset('js/extra_payments.js') }}"></script>
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
          <input type="radio" name="options" id="option1" autocomplete="off" value="0" class="property_refresh_check property_name_service" checked> ALL
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
          <input type="radio" name="options" id="option1" autocomplete="off" value="0" class="property_refresh_check property_name_airport" checked> ALL
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
  </div>
</div>
<div class="container-fluid pb-2 bg-light a_container">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-drivefly borderless">
        <tbody>
          <tr class="pointer">
            <td>Date</td>
            <td><span class="badge badge-secondary">Ref</span></td>
            <td>Name</td>
            <td>Service Intent</td>
            <td>Price</td>
            <td><span class="badge badge-pill badge-success">Status</span></td>
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
    <div class="col-md-12">
      <table class="table table-drivefly borderless">
        <tbody class="a_tbody">
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="list_item_template" style="display: none;">
  <table>
    <tbody>
      <tr class="pointer a_tr" data-toggle="modal" data-target="#editReportModal" data-report-id="">
        <td class="data__formated_date">Date</td>
        <td><span class="badge badge-secondary data__refNum">Ref</span></td>
        <td class="data_totname">Name</td>
        <td class="data_for">Service Intent</td>
        <td class="data_amount">Price</td>
        <td><span class="badge badge-pill badge-success data_status">Status</span></td>
      </tr>
    </tbody>
  </table>
</div>
  @include('modal')

@endsection