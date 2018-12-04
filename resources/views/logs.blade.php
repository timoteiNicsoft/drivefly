@extends('layouts.app')

@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>

<script src="{{ asset('js/logs.js') }}"></script>
@endsection
@section('content')
  <div class="template_search" style="display:none">
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
<div class="container-fluid pb-2 bg-light a_container">
 <div class="row mx-0 py-3 text-muted border-bottom a_loader" style="display: none;">
  <div style="margin: 0 auto; color: #777" class="">
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <div style="margin-bottom: 24px; font-size: 36px; line-height: 40px; font-weight: 900">One moment please</div>
    <p>We are looking for results using your criteria.</p>
  </div>
</div>

<div class="row" style="display: none;">
  <div class="col py-2">
    <button type="button" class="btn btn-primary a_button_refresh">Refresh</button>
  </div>
</div>

<div class="row" style="display: none;">
  <div class="col-md-12 pb-5">
    <table class="table table-drivefly borderless">
      <tbody class="a_tbody1">
      </tbody>
    </table>
  </div>
</div>
</div>

<div class="a_template_row1" style="display: none;">
  <table>
    <tbody>
      <tr class="a_tr1">
        <td style="width: 10%" class="data__date_formatted">PLACEHOLDER__DATE_FORMATTED</td>
        <td style="width: 10%"><span class="badge badge-success data__refNum">PLACEHOLDER__REFNUM</span></td>
        <td style="width: 70%">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th class="ttreps">Field</th>
                <th class="ttreps">Before</th>
                <th class="ttreps">After</th>
              </tr>
            </thead>
            <tbody class="a_tbody2">
            </tbody>
          </table>
        </td>
        <td style="width: 10%"></td>
      </tr>
    </tbody>
  </table>
</div>

<div class="a_template_row2" style="display: none;">
  <table>
    <tbody>
      <tr class="a_tr2">
        <td class="data_field">PLACEHOLDER_FIELD</td>
        <td class="data_before">PLACEHOLDER_BEFORE</td>
        <td class="data_after">PLACEHOLDER_AFTER</td>
      </tr>
    </tbody>
  </table>
</div>
@endsection