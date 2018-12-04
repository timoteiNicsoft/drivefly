@extends('layouts.app')

@section('javascript')
 <script src="{{ asset('js/dropzone.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>

@endsection

@section('content')
 <div class="container-fluid p-2 bg-white">
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
      <div class="row">
        <div class="col py-2">
          <form action="{{route('alerts_post')}}" method="post" class="form-inline">
            {{csrf_field()}}
            <div class="form-group px-2">
              <label>When Reg = </label>
              <input type="text" name="carReg" class="form-control mx-2 py-0" placeholder="PLAT3N0" maxlength="10" pattern="[A-Za-z0-9 ]{1,}" required>
            </div>

            <div class="form-group pr-2">
              <label>send to Email</label>
              <input type="email" name="email" class="form-control mx-2 py-0" placeholder="example@email.com" required>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
          </form>
        </div>
      </div>
    </div>

    <div class="container-fluid p-2 bg-light">


        @if(!$alerts || $alerts->count() < 1) 

            <div class="row">
                <div class="col-md-12">
                    No data found
                </div>
            </div>
        @else

            @foreach($alerts as $alert)

                <div class="row">
                <div class="col-md-12">
                  <div class="py-2 my-1 bg-white">
                    <form action="alerts.php" method="post" class="form-inline">
                      <input type="hidden" name="id" value="{{$alert->id}}" readonly>

                      <div class="form-group px-2">
                        <label>When Reg = </label>
                        <input type="text" class="form-control mx-2 py-0" value="{{$alert->carReg}}" readonly="readonly">
                      </div>

                      <div class="form-group pr-2">
                        <label>send to Email</label>
                        <input type="email" class="form-control mx-2 py-0" value="{{$alert->email}}" readonly="readonly">
                      </div>

                      <div class="form-group pr-2">
                        <label>created {{$alert->created}}</label>
                      </div>

                      <button type="submit" class="btn btn-secondary">Delete</button>
                    </form>
                  </div>
                </div>
                </div>
           @endforeach
         @endif
    </div>
    @include('modal')
@endsection