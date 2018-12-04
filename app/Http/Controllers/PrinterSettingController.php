<?php

namespace App\Http\Controllers;

use App\PrinterSetting;
use Auth;
use Illuminate\Http\Request;

class PrinterSettingController extends Controller
{
    public function index(){
        $settings = PrinterSetting::where('user_id', Auth::user()->id)->first();
        if(!$settings){
            $settings = $this->create_with_default_position();
        }
        return view('printer_settings', compact('settings'));
    }

    public function save_position(Request $request){
        $settings = PrinterSetting::where('user_id', Auth::user()->id)->first();
        $settings->barcode1 = $request->barcode1; 
        $settings->name = $request->name; 
        $settings->mobile = $request->mobile; 
        $settings->refNum = $request->refNum; 
        $settings->carReg = $request->carReg; 
        $settings->carModel = $request->carModel; 
        $settings->carColour = $request->carColour; 
        $settings->outDate = $request->outDate; 
        $settings->backDate = $request->backDate; 
        $settings->outTime = $request->outTime; 
        $settings->backTime = $request->backTime; 
        $settings->terminal_out = $request->terminal_out; 
        $settings->terminal_in = $request->terminal_in; 
        $settings->returnFlightNum = $request->returnFlightNum; 
        $settings->ppl = $request->ppl; 
        $settings->bigType = $request->bigType;
        $settings->backDateShort = $request->backDateShort; 
        $settings->backTime2 = $request->backTime2; 
        $settings->terminal_in2 = $request->terminal_in2; 
        $settings->refNum2 = $request->refNum2; 
        $settings->carReg2 = $request->carReg2; 
        $settings->carModel2 = $request->carModel2; 
        $settings->carColour2 = $request->carColour2; 
        $settings->barcode3 = $request->barcode3; 
        $settings->xtratext = $request->xtratext; 
        $settings->extraName = $request->extraName; 
        $settings->refNum3 = $request->refNum3; 
        $settings->carReg3 = $request->carReg3; 
        $settings->carModel3 = $request->carModel3; 
        $settings->carColour3 = $request->carColour3; 
        $settings->backDate3 = $request->backDate3; 
        $settings->backTime3 = $request->backTime3; 
        $settings->terminal_in3 = $request->terminal_in3; 
        $settings->returnFlightNum3 = $request->returnFlightNum3; 
        $settings->type = $request->type; 
        $settings->save();

        return response()->json(['message' => 'Position Save']);
    }

    function create_with_default_position(){
        $settings = new PrinterSetting();
        $settings->user_id = Auth::user()->id;
        $settings->barcode1 = 'left:30mm;top:16mm;';
        $settings->name = 'left:8mm;top:41mm;';
        $settings->mobile = 'left:8mm;top:51mm;';
        $settings->refNum = 'left:8mm;top:62mm;';
        $settings->carReg = 'left:7mm;top:82mm;';
        $settings->carModel = 'left:8mm;top:94mm;';
        $settings->carColour = 'left:66mm;top:94mm;';
        $settings->outDate = 'left:8mm;top:125mm;';
        $settings->backDate = 'left:8mm;top:136mm;';
        $settings->outTime = 'left:47mm;top:125mm;';
        $settings->backTime = 'left:47mm;top:135mm;';
        $settings->terminal_out = 'left:73mm;top:125mm;';
        $settings->terminal_in = 'left:73mm;top:136mm;';
        $settings->returnFlightNum = 'left:47mm;top:145mm;';
        $settings->ppl = 'left:97mm;top:145mm;';
        $settings->bigType = 'text-align:center;width:94mm;font-size: 2em ;left:98mm;top:0mm;';
        $settings->backDateShort = 'left:174mm;top:44mm;';
        $settings->backTime2 = 'left:124mm;top:86mm;';
        $settings->terminal_in2 = 'left:142mm;top:127mm;';
        $settings->refNum2 = 'left:103mm;top:176mm;';
        $settings->carReg2 = 'left:151mm;top:176mm;';
        $settings->carModel2 = 'left:104mm;top:186mm;';
        $settings->carColour2 = 'left:159mm;top:186mm;';
        $settings->barcode3 = 'left:232mm;top:16mm;';
        $settings->xtratext = 'left:199mm;top:62mm;';
        $settings->extraName = 'left:199mm;top:98mm;';
        $settings->refNum3 = 'left:199mm;top:113mm;';
        $settings->carReg3 = 'left:254mm;top:113mm;';
        $settings->carModel3 = 'left:199mm;top:125mm;';
        $settings->carColour3 = 'left:255mm;top:124mm;';
        $settings->backDate3 = 'left:200mm;top:135mm;';
        $settings->backTime3 = 'left:240mm;top:135mm;';
        $settings->terminal_in3 = 'left:265mm;top:135mm;';
        $settings->returnFlightNum3 = 'left:208mm;top:145mm;';
        $settings->type = 'left:244mm;top:145mm;';
        $settings->save();

        return $settings;
    }
}
