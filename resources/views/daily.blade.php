@extends('layouts.app')

@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>

<script src="{{ asset('js/daily.js') }}"></script>
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
        <button id="date_date" class="btn btn-secondary active" data-toggle="datetimepicker" data-target="#datetimepickerHidden">Today</button>
        <button id="date_forw" class="btn btn-secondary"><i class="fas fa-step-forward"></i></button>
      </div>
    </div>
  </div>
  <div class="row pb-3">
    <div class="offset-md-3 col-md-6 d-flex justify-content-md-center">
      <h2><script> document.write(new Date().toDateString()); </script> (Today)</h2>
    </div>
    <div class="col-md-3 d-flex justify-content-md-end">
      <button type="button" class="btn btn-primary">Print AM/PM</button>
    </div>
  </div>
</div>

<div class="container-fluid pb-2 bg-light">
  <div class="row mx-0 py-3 text-muted border-bottom list_container" id="daily-rows">
    <div class="col-md-6 list_container_left">
      <div class="row mx-0 pb-2 text-muted border-bottom">
        <div class="col-md-6">
          403
        </div>
        <div class="col-md-6 d-flex justify-content-md-end">
          <a target="_blank" class="btn btn-primary btn-sm pull-right mr-2">Print</a>
          <a target="_blank" class="btn btn-primary btn-sm">List</a>
        </div>
      </div>
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">L4P-1-1892702</span>
        </div>
        <div class="col-md-2">02:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Kerry Robinson</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning">KR10XNE</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">ZFH1ES</span>
        </div>
        <div class="col-md-2">02:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr Damon Blackburn</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">DP17HZX</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">181983486</span>
        </div>
        <div class="col-md-2">02:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mrs Jo Owen</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">J99OON</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">182000448</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr Scott Copeland</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">YE57WOA</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">CH181983861</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mrs Sarah Price</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">R88SJP</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">L4P-1-2228353</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Helen Caldwell</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">DU02EBM</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">SFP-1-2289852</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Sue Collings</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">MF63XPW</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">75QNR</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr J Oneil</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">DY12KPT</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">L4P-1-238886</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Danny Rhode</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">ML63BVR</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">FN049</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr R Holder</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">FJ67TXX</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3 mb-1">
          <span class="badge badge-success">L4P-1-2381267</span>
        </div>
        <div class="col-md-2 mb-1">03:30</div>
        <div class="col-md-1 mb-1"></div>
        <div class="col-md-4 mb-1">Barry</div>
        <div class="col-md-2 d-flex justify-content-end mb-1">
          <span class="badge badge-warning p-2">RO09VVB</span>
        </div>
        <div class="col-md-12">
          <div class="alert alert-warning py-1 m-0" role="alert">
            Landing is 13.10
          </div>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">CH181996340</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Barry</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">RO09VVB</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">181991996</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr Ettore Pisano</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">KF17FKO</span>
        </div>
      </div>
      <!-- /item -->
    </div>
    <div class="col-md-6  list_container_right">
      <div class="row mx-0 pb-2 text-muted border-bottom">
        <div class="col-md-6">
          743
        </div>
        <div class="col-md-6 d-flex justify-content-md-end">
          <a id="hrefdatelist_b" href="./fpdf/daily_print.php?date=2018-10-29&amp;airport=0&amp;type=" target="_blank" class="btn btn-primary btn-sm">List</a>
        </div>
      </div>
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">L4P-1-1892702</span>
        </div>
        <div class="col-md-2">02:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Kerry Robinson</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning">KR10XNE</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">ZFH1ES</span>
        </div>
        <div class="col-md-2">02:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr Damon Blackburn</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">DP17HZX</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">181983486</span>
        </div>
        <div class="col-md-2">02:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mrs Jo Owen</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">J99OON</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white" data-toggle="modal" data-target="#editReportModal" data-report-id="data_report_id">
        <div class="col-md-3">
          <span class="badge badge-success">182000448</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr Scott Copeland</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">YE57WOA</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">CH181983861</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mrs Sarah Price</div>
        <div class="col-md-2 d-flex justify-content-end mb-1">
          <span class="badge badge-warning p-2">R88SJP</span>
        </div>
        <div class="col-md-12">
          <div class="alert alert-warning py-1 m-0" role="alert">
            sabir took the car
          </div>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">L4P-1-2228353</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Helen Caldwell</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">DU02EBM</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">SFP-1-2289852</span>
        </div>
        <div class="col-md-2">03:00</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Sue Collings</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">MF63XPW</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">75QNR</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr J Oneil</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">DY12KPT</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">L4P-1-238886</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Danny Rhode</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">ML63BVR</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">FN049</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr R Holder</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">FJ67TXX</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3 mb-1">
          <span class="badge badge-success">L4P-1-2381267</span>
        </div>
        <div class="col-md-2 mb-1">03:30</div>
        <div class="col-md-1 mb-1"></div>
        <div class="col-md-4 mb-1">Barry</div>
        <div class="col-md-2 d-flex justify-content-end mb-1">
          <span class="badge badge-warning p-2">RO09VVB</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">CH181996340</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Barry</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">RO09VVB</span>
        </div>
      </div>
      <!-- /item -->
      <!-- item -->
      <div class="row mx-0 my-2 py-2 bg-white">
        <div class="col-md-3">
          <span class="badge badge-success">181991996</span>
        </div>
        <div class="col-md-2">03:30</div>
        <div class="col-md-1"></div>
        <div class="col-md-4">Mr Ettore Pisano</div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2">KF17FKO</span>
        </div>
      </div>
      <!-- /item -->
    </div>
  </div>
</div>

<div class="loader_container" style="display: none;">
  <div style="margin: 0 auto; color: #777" class="text-center">
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <div style="margin-bottom: 24px; font-size: 36px; line-height: 40px; font-weight: 900">One moment please</div>
    <p>We are looking for results using your criteria.</p>
  </div>
</div>

<div class="list_item_leaving_template" style="display: none;">
  <div class="col-md-6">
    <div class="row mx-0 pb-2 text-muted border-bottom">
      <div class="col-md-6 data_count">403</div>
      <div class="col-md-6 d-flex justify-content-md-end">
        <a id="hrefdateprint" href="./fpdf/daily_print.php?date=2018-10-29&amp;airport=0&amp;type=" target="_blank" class="btn btn-primary btn-sm pull-right mr-2">Print</a>
        <a id="hrefdatelist_a" href="./fpdf/daily_list.php?date=2018-10-29&amp;airport=0&amp;type=" target="_blank" class="btn btn-primary btn-sm">List</a></div>
      </div>
    </div>
  </div>

  <div class=" list_item_return_template" style="display: none;">
    <div class="col-md-6">
      <div class="row mx-0 pb-2 text-muted border-bottom">
        <div class="col-md-6 data_count">743</div>
        <div class="col-md-6 d-flex justify-content-md-end">
          <a id="hrefdatelist_b" href="./fpdf/daily_list.php?date=2018-10-29&amp;airport=0&amp;type=" target="_blank" class="btn btn-primary btn-sm">List</a></div>
        </div>
      </div>
    </div>

    <div class="list_item_template" style="display: none;">
      <div class="row mx-0 my-2 py-2 bg-white pointer" data-toggle="modal" data-target="#editReportModal" data-report-id="">
        <div class="col-md-3">
          <span class="badge badge-success data_refNum"></span>
        </div>
        <div class="col-md-2">
          <span class="span-tooltip data_color_selector_leavingDate data__leavingDate_formatted data__a_date" data-toggle="tooltip" data-placement="top" title="data__leavingDate_additional"></span>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-4 data__name"></div>
        <div class="col-md-2 d-flex justify-content-end">
          <span class="badge badge-warning p-2 data_carReg"></span>
        </div>
        <div class="col-md-12">
          <div class="alert alert-warning py-1 m-0 data_visibility_selector_notes data_notes" role="alert"></div>
        </div>
      </div>
    </div>
    @include('modal')

    @endsection