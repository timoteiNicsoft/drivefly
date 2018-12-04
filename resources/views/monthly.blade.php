@extends('layouts.app')

@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>

<script src="{{ asset('js/monthly.js') }}"></script>
@endsection
@section('header')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('content')
<?php
  $years = array(
        array('value' => date('Y', strtotime('-2 years')), 'label' => date('Y', strtotime('-2 years')), 'selected' => false),
        array('value' => date('Y', strtotime('-1 year')), 'label' => date('Y', strtotime('-1 year')), 'selected' => false),
        array('value' => date('Y'), 'label' => date('Y'), 'selected' => true),
        array('value' => date('Y', strtotime('+1 year')), 'label' => date('Y', strtotime('+1 year')), 'selected' => true),
    );

    $months = array();
    $date = strtotime(date('Y') . '-01-01');

    for ($i = 0; $i < 12; $i++) {

        $months[] = array('value' => date('m', strtotime('+' . $i . ' months', $date)), 'label' => date('M', strtotime('+' . $i . ' months', $date)), 'selected' => date('Y-m-d', strtotime('+' . $i . ' months', $date)) == date('Y-m-') . '01');
    }

?>

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

        <div class="col-sm-4 pb-sm-0 d-flex justify-content-md-end">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                @foreach($years as $k => $v)
                <label class="btn btn-secondary{if $_i.selected} active{/if}"><input type="radio" name="options" id="option1" autocomplete="off" value="{{$v['value']}}" class="property_refresh_check property_name_date_year"{if $_i.selected} checked{/if} >{{$v["value"]}}</label>
                @endforeach
            </div>
        </div>
    </div>
        <div class="row pb-3">
            <div class="offset-md-8 col-sm-4 d-flex justify-content-md-end">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                @foreach($months as $k => $v)
                  <label class="btn btn-outline-secondary btn-sm{if $_i.selected} active{/if}"><input type="radio" name="options" id="option1" autocomplete="off" value="{{$v['value']}}" class="property_refresh_check property_name_date_month"{if $_i.selected} checked{/if}> {{$v["value"]}} </label>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="container-fluid pb-2 bg-light a_container">
          <div class="row">
            <div class="col py-3">
              <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 54.51%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">16515 picks</div>
                <div class="progress-bar bg-info" role="progressbar" style="width: 45.49%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">picks 13781 drops</div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col pb-2">
              <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Show/Hide Products</button>
            </div>
          </div>

          <div class="row mx-0 py-3 text-muted border-bottom">
                <div class="col">
                    Agent
                </div>
                <div class="col">
                    Product
                </div>
                <div class="col text-center">
                    Bookings
                </div>
                <div class="col text-center">
                    Per Booking
                </div>
                <div class="col text-center">
                    Accuracy
                </div>
                <div class="col text-right">
                    Estimate Net
                </div>
          </div>

          <div class="row mx-0 accordion" id="accordionExample">
            <div class="col-md-12 mb-2 py-2 collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR D Park&Ride
                </div>
                <div class="col text-center">
                  99
                </div>
                <div class="col text-center">
                  £ 46.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 4742.62
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR D
                </div>
                <div class="col text-center">
                  305
                </div>
                <div class="col text-center">
                  £ 86.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 3742.62
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR T
                </div>
                <div class="col text-center">
                  78
                </div>
                <div class="col text-center">
                  £ 76.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 742.62
                </div>
              </div>
            </div>
            <div class="col-md-12 mb-2 py-2 bg-white" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  -
                </div>
                <div class="col text-center">
                  401
                </div>
                <div class="col text-center">
                  £ 860.64
                </div>
                <div class="col text-center">
                  80%
                </div>
                <div class="col text-right">
                  £ 34742.62
                </div>
              </div>
            </div>
          </div>

          <div class="row mx-0 accordion" id="accordionExample">
            <div class="col-md-12 mb-2 py-2 collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR D Park&Ride
                </div>
                <div class="col text-center">
                  99
                </div>
                <div class="col text-center">
                  £ 46.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 4742.62
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR D
                </div>
                <div class="col text-center">
                  305
                </div>
                <div class="col text-center">
                  £ 86.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 3742.62
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR T
                </div>
                <div class="col text-center">
                  78
                </div>
                <div class="col text-center">
                  £ 76.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 742.62
                </div>
              </div>
            </div>
            <div class="col-md-12 mb-2 py-2 bg-white" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  -
                </div>
                <div class="col text-center">
                  401
                </div>
                <div class="col text-center">
                  £ 860.64
                </div>
                <div class="col text-center">
                  80%
                </div>
                <div class="col text-right">
                  £ 34742.62
                </div>
              </div>
            </div>
          </div>

          <div class="row mx-0 accordion" id="accordionExample">
            <div class="col-md-12 mb-2 py-2 collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR D Park&Ride
                </div>
                <div class="col text-center">
                  99
                </div>
                <div class="col text-center">
                  £ 46.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 4742.62
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR D
                </div>
                <div class="col text-center">
                  305
                </div>
                <div class="col text-center">
                  £ 86.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 3742.62
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  LHR T
                </div>
                <div class="col text-center">
                  78
                </div>
                <div class="col text-center">
                  £ 76.64
                </div>
                <div class="col text-center">
                  100%
                </div>
                <div class="col text-right">
                  £ 742.62
                </div>
              </div>
            </div>
            <div class="col-md-12 mb-2 py-2 bg-white" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <div class="row">
                <div class="col">
                  Drivefly
                </div>
                <div class="col">
                  -
                </div>
                <div class="col text-center">
                  401
                </div>
                <div class="col text-center">
                  £ 860.64
                </div>
                <div class="col text-center">
                  80%
                </div>
                <div class="col text-right">
                  £ 34742.62
                </div>
              </div>
            </div>
          </div>

          <div class="row mx-0 accordion" id="accordionExample">
            <div class="col-md-12 mb-2 py-2 bg-white">
              <div class="row" style="font-size: 20px; font-weight: bold;">
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col text-center">
                  6136
                </div>
                <div class="col text-center">
                  <span style="font-size:14px;">per booking</span> £ 69.12</td>
                </div>
                <div class="col text-center">
                </div>
                <div class="col text-right">
                  £ 424105.2
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 bg-white mt-2">
            <div class="row">
              <div class="col">
                <div id="piechart" style="width: 100%; height: 800px;"></div>
              </div>
              <div class="col d-flex align-items-center">
                <div id="columnchart" style="width: 100%; height: 400px;"></div>
              </div>
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
    <div>
        <div class="row">
            <div class="col py-3">
                <div class="progress">
                    <div class="progress-bar bg-success a_total_out" role="progressbar" style="width: 50%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">0 picks</div>
                    <div class="progress-bar bg-info a_total_in" role="progressbar" style="width: 50%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">0 drops</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col pb-2">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Show/Hide Products</button>
            </div>
        </div>

        <div class="row mx-0 py-3 text-muted border-bottom">
            <div class="col">Agent</div>
            <div class="col">Product</div>
            <div class="col text-center">Bookings</div>
            <div class="col text-center">Per Booking</div>
            <div class="col text-center">Accuracy</div>
            <div class="col text-right">Estimate Net</div>
        </div>

        <div class="row mx-0 accordion a_table_after" id="accordionExample">
            <div class="col-md-12 mb-2 py-2 bg-white">
                <div class="row" style="font-size: 20px; font-weight: bold;">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col text-center a_data_bookings">&nbsp;</div>
                    <div class="col text-center a_data_per_booking a_per_booking_pound">&nbsp;</div>
                    <div class="col text-center"></div>
                    <div class="col text-right a_data_estimate_net a_pound">&nbsp;</div>
                </div>
            </div>
        </div>

        <div class="col-md-12 bg-white mt-2">
            <div class="row">
                <div class="col"><div id="piechart" style="width: 100%; height: 800px;"></div></div>
                <div class="col d-flex align-items-center"><div id="columnchart" style="width: 100%; height: 400px;"></div></div>
            </div>
        </div>
    </div>
</div>

<div class="list_template_item" style="display: none;">
    <div class="row mx-0 accordion" id="accordionExample">
        <div class="col-md-12 mb-2 py-2 collapse a_row" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample"></div>
        <div class="col-md-12 mb-2 py-2 bg-white a_head" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></div>
    </div>
</div>

<div class="list_template_item_row" style="display: none;">
    <div class="row">
        <div class="col">&nbsp;</div>
        <div class="col">&nbsp;</div>
        <div class="col text-center"></div>
        <div class="col text-center a_pound"></div>
        <div class="col text-center a_percent_removed_to_be_calculated"></div>
        <div class="col text-right a_pound"></div>
    </div>
</div>

<div class="list_template_item_head" style="display: none;">
    <div class="row">
        <div class="col">&nbsp;</div>
        <div class="col">&nbsp;</div>
        <div class="col text-center"></div>
        <div class="col text-center a_pound"></div>
        <div class="col text-center a_percent_removed_to_be_calculated"></div>
        <div class="col text-right a_pound"></div>
    </div>
</div>


@include('modal')
@endsection
