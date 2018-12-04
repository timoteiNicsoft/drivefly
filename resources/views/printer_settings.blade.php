<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <title>DriveFly</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/printer_settings.css') }}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>Printer Settings</title>
  </head>
  <body class="bg_grey">
      <form method="POST" action="{{ route('save_position_printer') }}" id="save_position_form">
        @csrf
        <input type="hidden" name="barcode1" value="{{ $settings->barcode1 }}">
        <input type="hidden" name="name" value="{{ $settings->name }}">
        <input type="hidden" name="mobile" value="{{ $settings->mobile }}">
        <input type="hidden" name="refNum" value="{{ $settings->refNum }}">
        <input type="hidden" name="carReg" value="{{ $settings->carReg }}">
        <input type="hidden" name="carModel" value="{{ $settings->carModel }}">
        <input type="hidden" name="carColour" value="{{ $settings->carColour }}">
        <input type="hidden" name="outDate" value="{{ $settings->outDate }}">
        <input type="hidden" name="backDate" value="{{ $settings->backDate }}">
        <input type="hidden" name="outTime" value="{{ $settings->outTime }}">
        <input type="hidden" name="backTime" value="{{ $settings->backTime }}">
        <input type="hidden" name="terminal_out" value="{{ $settings->terminal_out }}">
        <input type="hidden" name="terminal_in" value="{{ $settings->terminal_in }}">
        <input type="hidden" name="returnFlightNum" value="{{ $settings->returnFlightNum }}">
        <input type="hidden" name="ppl" value="{{ $settings->ppl }}">
        <input type="hidden" name="bigType" value="{{ $settings->bigType }}">
        <input type="hidden" name="backDateShort" value="{{ $settings->backDateShort }}">
        <input type="hidden" name="backTime2" value="{{ $settings->backTime2 }}">
        <input type="hidden" name="terminal_in2" value="{{ $settings->terminal_in2 }}">
        <input type="hidden" name="refNum2" value="{{ $settings->refNum2 }}">
        <input type="hidden" name="carReg2" value="{{ $settings->carReg2 }}">
        <input type="hidden" name="carModel2" value="{{ $settings->carModel2 }}">
        <input type="hidden" name="carColour2" value="{{ $settings->carColour2 }}">
        <input type="hidden" name="barcode3" value="{{ $settings->barcode3 }}">
        <input type="hidden" name="xtratext" value="{{ $settings->xtratext }}">
        <input type="hidden" name="extraName" value="{{ $settings->extraName }}">
        <input type="hidden" name="refNum3" value="{{ $settings->refNum3 }}">
        <input type="hidden" name="carReg3" value="{{ $settings->carReg3 }}">
        <input type="hidden" name="carModel3" value="{{ $settings->carModel3 }}">
        <input type="hidden" name="carColour3" value="{{ $settings->carColour3 }}">
        <input type="hidden" name="backDate3" value="{{ $settings->backDate3 }}">
        <input type="hidden" name="backTime3" value="{{ $settings->backTime3 }}">
        <input type="hidden" name="terminal_in3" value="{{ $settings->terminal_in3 }}">
        <input type="hidden" name="returnFlightNum3" value="{{ $settings->returnFlightNum3 }}">
        <input type="hidden" name="type" value="{{ $settings->type }}">
      </form>
      <div class="box_papper position-relative">
        <div id="barcode1" class="bar_code_h" style="{{ $settings->barcode1 }}"></div>
        <div id="name" class="md" style="{{ $settings->name }}">Michael </div>
        <div id="mobile" class="md" style="{{ $settings->mobile }}">07734745093</div>
        <div id="refNum" class="md" style="{{ $settings->refNum }}">ICPR545385</div>

        <div id="carReg" class="md" style="{{ $settings->carReg }}">Fx17lvz</div>
        <div id="carModel" style="{{ $settings->carModel }}">Volvo v40</div>
        <div id="carColour" style="{{ $settings->carColour }}">Black</div>

        <div id="outDate" style="{{ $settings->outDate }}">30-06-2017</div>
        <div id="backDate" style="{{ $settings->backDate }}">03-07-2017</div>
        <div id="outTime" style="{{ $settings->outTime }}">04:00</div>
        <div id="backTime" style="{{ $settings->backTime }}">12:15</div>
        <div id="terminal_out" style="{{ $settings->terminal_out }}"></div>
        <div id="terminal_in" style="{{ $settings->terminal_in }}"></div>

        <div id="returnFlightNum" style="{{ $settings->returnFlightNum }}">Mt1249</div>
        <div id="ppl" style="{{ $settings->ppl }}">1</div>

        <!-- ~~~~~~~~~~~~ -->

        <div id="bigType" class="big_type_style" style="{{ $settings->bigType }}">Park &amp; Ride</div>
        <div id="backDateShort" class="lg" style="{{ $settings->backDateShort }}">03/07</div>
        <div id="backTime2" class="lg" style="{{ $settings->backTime2 }}">12:15</div>
        <div id="terminal_in2" class="lg" style="{{ $settings->terminal_in2 }}"></div>

        <div id="refNum2" class="md" style="{{ $settings->refNum2 }}">ICPR545385</div>
        <div id="carReg2" class="md" style="{{ $settings->carReg2 }}">Fx17lvz</div>
        <div id="carModel2" style="{{ $settings->carModel2 }}">Volvo v40</div>
        <div id="carColour2" style="{{ $settings->carColour2 }}">Black</div>

        <!-- ~~~~~~~~~~~~ -->
        <div id="barcode3" class="bar_code_h" style="{{ $settings->barcode3 }}"></div>
        <div id="xtratext" class="md" style="{{ $settings->xtratext }}">Bus Stop <b>A</b><br>Returning <b>1</b> passenger</div>
        <div id="extraName" class="md" style="{{ $settings->extraName }}">Michael </div>


        <div id="refNum3" class="md" style="{{ $settings->refNum3 }}">ICPR545385</div>
        <div id="carReg3" class="md" style="{{ $settings->carReg3 }}">Fx17lvz</div>
        <div id="carModel3" style="{{ $settings->carModel3 }}">Volvo v40</div>
        <div id="carColour3" style="{{ $settings->carColour3 }}">Black</div>

        <div id="backDate3" style="{{ $settings->backDate3 }}">03-07-2017</div>
        <div id="backTime3" style="{{ $settings->backTime3 }}">12:15</div>
        <div id="terminal_in3" style="{{ $settings->terminal_in3 }}"></div>
        <div id="returnFlightNum3" style="{{ $settings->returnFlightNum3 }}">Mt1249</div>
        <div id="type" style="{{ $settings->type }}">Park and Ride</div>

        <!-- ~~~~~~~~~~~~ -->
      </div>
      <div class="commands_position" id="mydiv">
        <div id="mydivheader">Drag here to move</div>
        <input type="hidden" id="item_selected" value="">
        <div class="arrows_directions">
          <div class="d-flex justify-content-center mx-0">
            <button class="arrow_direction arrow_top mx-2 mb-2" data-direction="up">UP</button>
          </div>
          <div class="d-flex justify-content-center mx-0">
            <button class="arrow_direction arrow_left mr-1" data-direction="left">LEFT</button>
            <button class="arrow_direction arrow_down mx-2" data-direction="down">DOWN</button>
            <button class="arrow_direction arrow_right ml-1" data-direction="right">RIGHT</button>
          </div>
        </div>
        <div class="action_buttons">
          <div class="d-flex justify-content-between mt-3 mx-0">
            <button class="save_printer_settings">SAVE AS {{ Auth::user()->username }}</button>
            <button class="print_test">TEST PRINT</button>
          </div>
        </div>
      </div>
      <script src="{{ asset('js/printer_settings.js') }}"></script>
  </body>
</html>