<?php

namespace App\Http\Controllers;
use Log;
use App\Report;
use App\AuditTrail;
use Illuminate\Http\Request;
use App\Helpers\HelperFunctions;
use \Carbon\Carbon;
use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }

    public function ajax_report_cancel(Request $request){

    }

    public function ajax_report(Request $request){
        $help_func = new HelperFunctions;

        $report = Report::where('id',$request->report)->with(['service','airport','consolidator'])->first();
        if($report){
            $report_array[0]['_created_relative']         = $help_func->relativeTime(strtotime($report->created));
            $report_array[0]['_created_formatted']        = date('j M h:i', strtotime($report->created));
            $report_array[0]['_lastUpdate_formatted']     = date('j M h:i', strtotime($report->lastUpdate));
            $report_array[0]['_name']                     = $report->firstname . ' ' . $report->surname;
            $report_array[0]['_leavingDate_formatted']    = date('d/m/Y', strtotime($report->leavingDate));
            $report_array[0]['_leavingDate_additional']   = date('H:i', strtotime($report->leavingDate));
            $report_array[0]['_returnDate_formatted']     = date('d/m/Y', strtotime($report->returnDate));
            $report_array[0]['_returnDate_additional']    = date('H:i', strtotime($report->returnDate));
            $report_array[0]['_consolidator_name']        = $report->consolidator->name;
            $report_array[0]['_airport_acronym']          = $report->airport->acronym;
            $report_array[0]['_airport_name']             = $report->airport->name;
            $report_array[0]['_type_acronym']             = $report->service->acronym;
            $report_array[0]['_type_name']                = $report->service->name;

            $report_array[0]['refNum']                    = $report->refNum;
            $report_array[0]['product']                   = $report->product;

            $report_array[0]['terminal_in']               = $report->terminal_in;
            $report_array[0]['terminal_out']              = $report->terminal_out;

            $report_array[0]['surname']                   = $report->surname;
            $report_array[0]['mobile']                    = $report->mobile;
            $report_array[0]['email']                     = $report->email;

            $report_array[0]['fullName']                  = $report->fullName;
            $report_array[0]['payment']                   = $report->payment;
            $report_array[0]['returnFlightNum']           = $report->returnFlightNum;


            if($report->status == 'Ok' || $report->status == 'ok' || $report->status == 'OK') {
                $report_array[0]['status'] = 'OK';
            }
            elseif($report->status == 'ACTIVE' || $report->status == 'Active' || $report->status == 'active') {
                $report_array[0]['status'] = 'Active';
            }
            else {
                $report_array[0]['status'] = $report->status;
            }

            $report_array[0]['carModel']                  = $report->carModel;
            $report_array[0]['carColour']                 = $report->carColour;
            $report_array[0]['carReg']                    = $report->carReg;

            if(!empty($report->amountPaid)) {

                $report_array[0]['amountPaid']            = '£ '.$report->amountPaid;
            }

            $report_array[0]['net']                       = '£ '.$report->net;

            if(!empty($report->commission)) {

                $report_array[0]['commission']            = '£ '.$report->commission;
            }

            $report_array[0]['notes']                     = $report->notes;
            $pay_res = $report->extra_payments;
            foreach($pay_res as $pay){
                $report_array[0]['_payment'][] = $pay;
            }

            $audit_trails = $report->audit_trails;
            if($audit_trails){
                foreach($audit_trails as $at){
                    $report_array[0]['_auditTrail'][]['_record']  = json_decode($at->record);
                }
            }

            return response()->json($report_array[0]);
        }else{
            return response()->json(["process" => "fail", "message" => "entry failed to be fetched"]);
        }
    }

    public function ajax_reports(Request $request){
        $reports_array = Report::with(['airport','service','extra_payments'])->take(50)->get();
        if($request->service && $request->service>0){
            $reports_array = $reports_array->where('typeID', $request->service);
        }

        if($request->airport && $request->airport>0){
            $reports_array = $reports_array->where('airportID', $request->airport);
        }

        if($request->consolidator && $request->consolidator>0){
            $reports_array = $reports_array->where('consolidatorID', $request->consolidator);
        }

        if($request->date){
            $reports_array = $reports_array->filter( function ($report) use ($request){
                $req = Carbon::parse($request->date);
                $leavingDate = Carbon::parse($report->leavingDate);
                $returnDate = Carbon::parse($report->returnDate);
                return $req->diffInDays($leavingDate) == 0 || $req->diffInDays($returnDate) == 0;
            });
        }

        $reports=[];
        $today = new \DateTime();
        $today->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison
        $help_func = new HelperFunctions;
        $reports_array = $reports_array->toArray();
        foreach ($reports_array as $reportIndex => $reportItem) {


            $timestamp  = $reportItem['leavingDate'];
            $match_date = \DateTime::createFromFormat( "Y-m-d H:i:s", (string)$timestamp );
            $match_date->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

            $diff       = $today->diff( $match_date );
            $diffDays   = (integer)$diff->format( "%R%a" ); // Extract days count in interval

            switch( $diffDays ) {
                case 0:
                    //echo "//Today";
                $reports[$reportIndex]['_leavingDate_formatted'] = '<span style="padding: 2px; font-size: 13px; color: #1E8449 !important; border: 1px solid #99ff99; border-radius: 3px; text-shadow: 0px 0px 2px #00FF30;">'.date('j M', strtotime($reportItem['leavingDate'])).'</span>';
                break;
                case -1:
                    //echo "//Yesterday";
                $reports[$reportIndex]['_leavingDate_formatted'] = '<span style="color:black !important;">'.date('j M', strtotime($reportItem['leavingDate'])).'</span>';
                break;
                case +1:
                    //echo "//Tomorrow";
                $reports[$reportIndex]['_leavingDate_formatted'] = '<span style="padding: 2px; font-size: 13px; color: #333 !important; border: 1px solid #ffa400; border-radius: 3px; text-shadow: 0px 0px 2px #ffa400;">'.date('j M', strtotime($reportItem['leavingDate'])).'</span>';
                break;
                case +1:
                    //echo "//Day After Tomorrow";
                $reports[$reportIndex]['_leavingDate_formatted'] = '<span style="color:black !important;">'.date('j M', strtotime($reportItem['leavingDate'])).'</span>';
                break;
                default:
                    //echo "//Sometime";
                $reports[$reportIndex]['_leavingDate_formatted'] = '<span style="color:black !important;">'.date('j M', strtotime($reportItem['leavingDate'])).'</span>';
            }


            $reports[$reportIndex]['id']                        = $reportItem['id'];
            $reports[$reportIndex]['_created_relative']         = date('j M H:i', strtotime($reportItem['created']));
            $reports[$reportIndex]['_created_formatted']        = $help_func->relativeTime(strtotime($reportItem['created']));
            $reports[$reportIndex]['_name']                     = $reportItem['firstname'] . ' ' . $reportItem['surname'];
            $reports[$reportIndex]['_leavingDate_additional']   = date('H:i', strtotime($reportItem['leavingDate']));
            $reports[$reportIndex]['_returnDate_formatted']     = date('j M', strtotime($reportItem['returnDate']));
            $reports[$reportIndex]['_returnDate_additional']    = date('H:i', strtotime($reportItem['returnDate']));
            $reports[$reportIndex]['consolidatorName']          = $reportItem['consolidatorName'];
            $reports[$reportIndex]['fullName']                  = $reportItem['fullName'];
            $reports[$reportIndex]['product']                   = $reportItem['product'];
            $reports[$reportIndex]['payment']                   = $reportItem['payment'];

            $reports[$reportIndex]['_airport_name']             = $reportItem['airport']['name'];
            $reports[$reportIndex]['_airport_acronym']          = $reportItem['airport']['acronym'];
            if(count($reportItem['extra_payments'])>0){
                $reports[$reportIndex]['xpayment']                  = $reportItem['extra_payments'][0]['amount'];
            }else{
                $reports[$reportIndex]['xpayment'] = '';
            }

            $reports[$reportIndex]['leavingDate']               = $reportItem['leavingDate'];
            $reports[$reportIndex]['returnDate']                = $reportItem['returnDate'];
            $reports[$reportIndex]['returnFlightNum']           = $reportItem['returnFlightNum'];
            $reports[$reportIndex]['returnFlightTime']          = $reportItem['returnFlightTime'];
            $reports[$reportIndex]['terminal_out']              = $reportItem['terminal_out'];
            $reports[$reportIndex]['terminal_in']               = $reportItem['terminal_in'];
            $reports[$reportIndex]['carModel']                  = $reportItem['carModel'];
            $reports[$reportIndex]['carColour']                 = $reportItem['carColour'];
            $reports[$reportIndex]['carReg']                    = $reportItem['carReg'];
            $reports[$reportIndex]['refNum']                    = $reportItem['refNum'];
            $reports[$reportIndex]['amountPaid']                = $reportItem['amountPaid'];
            $reports[$reportIndex]['net']                       = $reportItem['net'];
            $reports[$reportIndex]['commission']                = $reportItem['commission'];
            $reports[$reportIndex]['notes']                     = $reportItem['notes'];

            $reports[$reportIndex]['typeID']                    = $reportItem['typeID'];

            if($reportItem['status'] == 'Ok' || $reportItem['status'] == 'ok' || $reportItem['status'] == 'New' ) {

                $status = 'OK';
            }
            elseif($reportItem['status'] == 'ACTIVE' || $reportItem['status'] == 'Active') {

                $status = 'Active';
            }
            elseif($reportItem['status'] == 'Amendment' || $reportItem['status'] == 'AMENDMENT') {

                $status = 'Amended';
            }
            elseif($reportItem['status'] == 'CANCEL') {

                $status = 'Cancelled';
            }
            else {
                $status = $reportItem['status'];
            }

            $reports[$reportIndex]['status']                    = $status;
            $reports[$reportIndex]['_type_acronym']             = $reportItem['service']['acronym'];
            $reports[$reportIndex]['_type_name']                 = $reportItem['service']['name'];


        }
        return response()->json($reports);
    }

    public function ajax_report_save(Request $request){
        $_fullName  = explode(' ', $request->fullName);

        $request->firstname  = $_fullName[0];
        $request->surname    = $_fullName[1] .' '.$_fullName[2];
        $validatedData = Validator::make($request->all(),[ 
            'report' => 'required',
            'fullName' => 'required|alpha',
            'firstname' => 'required|alpha',
            'surname' => 'required|alpha',
            'email' => 'required|email',
            'mobile' => 'required|regex:/^[0-9\-\.\+]{5,20}$/',
            'leavingDate' => 'required|date',
            'returnDate' => 'required|date',
            'carModel' => 'required|date',
            'carColour' => 'required|alpha_num',
            'carReg' => 'required|alpha_num',
            'returnFlightNum' => 'required|regex:/^[A-Za-z0-9]{1,}$/',
            'terminal_in' => 'required|regex:/^[A-Za-z0-9]{1,}$/',
            'terminal_out' => 'required|regex:/^[A-Za-z0-9]{1,}$/',
        ]);

        if($validatedData->fails()){
            return response()->json($validatedData->errors(),400);
        }else{
            $report = Report::findOrFail($request->report);
            $auditTrailFields = array(
              'leavingDate',
              'returnDate',
              'carModel',
              'carColour',
              'carReg',
              'returnFlightNum',
              'terminal_in',
              'terminal_out',
              'notes'
          );

            $auditTrailResult = array();

            foreach ($auditTrailFields as $auditTrailFieldIndex => $auditTrailFieldValue) {
              if ($_POST[$auditTrailFieldValue] != $report[0][$auditTrailFieldValue]) {
                $auditTrailResult[] = array(
                  'field' => $auditTrailFieldValue,
                  'before' => $report[0][$auditTrailFieldValue],
                  'after' => $_POST[$auditTrailFieldValue]
                    );
                }
            }
        if (count($auditTrailResult)) {
              $audit_trail = new AuditTrail;
              $audit_trail->report = $request->report;
              $audit_trail->record = json_encode($auditTrailResult, JSON_PRETTY_PRINT);
              $audit_trail->save();
            }
            $report->fullname = $request->fullName;
            $report->firstname = $request->firstname;
            $report->surname = $request->surname;
            $report->email = $request->email;
            $report->mobile = $request->mobile;
            $report->status = 'Amended';
            $report->leavingDate = $request->leavingDate;
            $report->returnDate = $request->returnDate;
            $report->carModel = $request->carModel;
            $report->carColour = $request->carColour;
            $report->carReg = $request->carReg;
            $report->returnFlightNum = $request->returnFlightNum;
            $report->terminal_in = $request->terminal_in;
            $report->terminal_out = $request->terminal_out;
            $report->notes = $request->notes;
            $report->picked_by_val = $request->picked_by;
            $report->dropped_by_val = $request->dropped_by;
            $report->save();
    }
    return response()->json(['result'=>'OK']);
}
}
