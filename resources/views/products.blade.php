@extends('layouts.app')
@section('header')
<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
@endsection
@section('javascript')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
 <script src="{{ asset('js/dropzone.js') }}"></script>
<script src="{{ asset('js/products.js') }}"></script>
@endsection

@section('content')
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

   <!-- // start products -->

   <div class="container-fluid pb-2 bg-light">
     <div class="row py-3">
       <div class="col-md-3">

         <div class="row mx-0 py-3 text-muted border-bottom">
           <div class="col">
               Companies
           </div>
         </div>

         <div class="row mx-0 my-2 py-2 bg-white"  data-toggle="collapse" data-target="#collapseDrivefly" aria-expanded="true" aria-controls="collapseDrivefly">
           <div class="col">
             <span>
               Drivefly
             </span>
           </div>
         </div>

         <div class="row mx-0 my-2 py-2 bg-white  collapsed"  data-toggle="collapse" data-target="#collapseICPR" aria-expanded="false" aria-controls="collapseICPR">
           <div class="col">
             <span>
               ICPR
             </span>
           </div>
         </div>

       </div>


       <div class="col-md-9" id="accordionProducts">

         <div class="row mx-0 py-3 text-muted border-bottom">
           <div class="col">
               Product
           </div>
         </div>

         <div class="collapse" id="collapseDrivefly" data-parent="#accordionProducts">
           <div class="panel panel-default p-2 bg-white mt-2">

             <table class="table table-striped table-hover table-borderless">
               <thead>
                 <tr>
                   <th class="products-table">Name</th>
                   <th>Airport</th>
                   <th>Type</th>
                   <th>Show on DriveFly.co.uk</th>
                 </tr>
               </thead>

                <tbody>
                  @if(!$products)
                    <tr class="success" data-toggle="collapse" data-target="#collapseDriveflyNone" aria-expanded="true" aria-controls="collapseDriveflyNone">
                      <td>N/A</td>
                      <td>N/A</td>
                      <td>N/A</td>
                      <td>No data</td>
                    </tr>
                  @else
                    @foreach($products as $product)
                    <tr class="success" data-toggle="collapse" data-target="#collapse-{{ $product->id }}" aria-expanded="true" aria-controls="collapse-{{ $product->id }}">
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->airport->acronym }}</td>
                      <td>MG</td>
                      <td>
                        <button type="button" class="btn btn-sm {{ $product->show_hide_glag == '1' ? 'btn-success' : 'btn-default' }} send_show_hide_glag" data-product_id="{{ $product->id }}">{{ $product->show_hide_glag == '1' ? 'On' : 'Off' }}</button>
                      </td>
                    </tr>
                    @endforeach
                  @endif
               </tbody>
             </table>
           </div>
         </div>

         <div class="collapse" id="collapseICPR" data-parent="#accordionProducts">
             <div class="panel panel-default p-2 bg-white mt-2">

               <table class="table table-striped table-hover table-borderless">
                 <thead>
                   <tr>
                     <th class="products-table">Name</th>
                     <th>Airport</th>
                     <th>Type</th>
                     <th>Show on DriveFly.co.uk</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr class="success">
                     <td>I Can Park & Ride Flex</td>
                     <td>BHX</td>
                     <td>PR</td>
                     <td>
                       <button type="button" class="btn btn-sm btn-success">On</button>
                       <button type="button" class="btn btn-sm btn-default">Off</button>
                     </td>
                   </tr>
                   <tr class="success">
                     <td>I Can Park & Ride Flex</td>
                     <td>BHX</td>
                     <td>PR</td>
                     <td>
                       <button type="button" class="btn btn-sm btn-success">On</button>
                       <button type="button" class="btn btn-sm btn-default">Off</button>
                     </td>
                   </tr>
                 </tbody>
               </table>
             </div>
           </div>

         </div>

       </div>
<!--         <div class="row sticky" style="height: 80px; display: block;" sticky-class="sticky-on" sticky="">
            <div class="col-md-12 d-flex justify-content-end">
                <button type="button" class="btn btn-warning" >Save changes</button>
            </div>
        </div> -->

        @if($products)
        <div id="accordionEditor">
          @foreach($products as $product)
          <div class="collapse" id="collapse-{{ $product->id }}" data-parent="#accordionEditor">
            <div class="row mx-0 py-3 text-muted border-bottom" id="accordionEditor">
              <div class="col">
                  Editor
              </div>
            </div>
            <div class="row mx-0 my-2 py-4 bg-white">
              <div class="col-3">
                <form method="POST" action="{{ route('product_update', $product->id ) }}" enctype="multipart/form-data" id="upload_form">
                  {{method_field('PUT')}}
                  @csrf
                  <div class="form-group">
                      <label for="product_name">Product Name</label>
                      <input type="text" name="name" class="form-control" id="product_name" maxlength="50" placeholder="Product Name" value="{{ $product->name }}">
                  </div>
                  <hr>
                  <div class="form-group">
                      <label for="product_name">Product Airport</label>
                      <select class="form-control" name="airport">
                          <option value="1" {{ $product->airport->acronym == 'LHR' ? 'selected' : '' }}>LHR</option>
                          <option value="2" {{ $product->airport->acronym == 'BHX' ? 'selected' : '' }}>BHX</option>
                          <option value="3" {{ $product->airport->acronym == 'LTN' ? 'selected' : '' }}>LTN</option>
                      </select>
                  </div>
                  <hr>
                  <div class="form-group">
                      <label for="product_name">Product Type</label>
                      <select class="form-control" name="service">
                          <option value="1" {{ $product->service->acronym == 'MG' ? 'selected' : '' }}>Meet&amp;Greet</option>
                          <option value="2" {{ $product->service->acronym == 'PR' ? 'selected' : '' }}>Park&amp;Ride</option>
                      </select>
                  </div>
                  <hr>
                  <div class="form-group">
                      <label for="product_code">Product Code</label>
                      <input type="text" class="form-control" id="product_code" maxlength="5" placeholder="D" name="code" value="{{ $product->product_code ? $product->product_code : '' }}">
                  </div>
                  <hr>
                  <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="check_1_{{ $product->id }}" name="is_amendable" {{ $product->is_amendable == '1' ? 'checked' : '' }}>
                      <label class="form-check-label" for="check_1_{{ $product->id }}">Product is amendable</label>
                  </div>
                  <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="check_2_{{ $product->id }}" name="is_refundable" {{ $product->is_refundable == '1' ? 'checked' : '' }}>
                      <label class="form-check-label" for="check_2_{{ $product->id }}">Product is refundable</label>
                  </div>
                  <hr>
                  <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="check_3_{{ $product->id }}" name="sell_as_agent" {{ $product->sell_as_agent == '1' ? 'checked' : '' }}>
                      <label class="form-check-label" for="check_3_{{ $product->id }}">Sell as agent</label>
                  </div>
                  <hr>
                  <div class="col" id="image_{{ $product->id }}">
                    @if($product->image)
                      <img alt="" class="product_image" src="{{ asset($product->image) }}">
                    @else
                      <img alt="" class="product_image" src="https://api.drivefly.org/assets/15.png">
                    @endif
                      <input type="file" name="photo">
                  </div>
                  <hr>
                  <div id="alert_main_content_{{ $product->id }}"></div>
                  <button class="btn btn-primary btn-small submit_changes_product">
                    Save Changes
                  </button>
                </form>
              </div>

              <div class="col-9">
                    <div class="form-group">
                        <label for="product_code">Short Description (max length 500)</button></label>
                        <div class="card bg-light mb-3 editor-container" data-editor="editor-description-{{ $product->id }}" id="editor-description-{{ $product->id }}">
                            <div class="card-body">
                              {!! $product->product_description !!}
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-small save_product" data-product_id="{{ $product->id }}" data-content="description" data-editor="editor-description-{{ $product->id }}">save</button>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="product_code">Product info</label>
                        <div class="card bg-light mb-3 editor-container" data-editor="editor-info-{{ $product->id }}" id="editor-info-{{ $product->id }}">
                            <div class="card-body">
                                {!! $product->product_info !!}
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-small save_product" data-product_id="{{ $product->id }}" data-content="info" data-editor="editor-info-{{ $product->id }}">save</button>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="product_code">Product Directions</label>
                        <div class="card bg-light mb-3 editor-container" data-editor="editor-directions-{{ $product->id }}" id="editor-directions-{{ $product->id }}">
                            <div class="card-body">
                                {!! $product->product_directions !!}
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-small save_product" data-product_id="{{ $product->id }}" data-content="directions" data-editor="editor-directions-{{ $product->id }}">save</button>
                    </div>
              </div>
            </div>
          </div>
          @endforeach
          </div>
        @endif
   </div>
   <script type="text/javascript">
    $('.editor-container').each(function(index){
      var id_editor = $(this).data('editor');

      var quill = new Quill('#'+id_editor, {
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block']
          ]
        },
        placeholder: 'Compose an epic...',
        theme: 'snow'  // or 'bubble'
      });
    });
   </script>
   <!-- // stop products -->
@include('modal')
@endsection
