<?php

namespace App\Http\Controllers;

use App\ExtraPayment;
use Illuminate\Http\Request;

class ExtraPaymentController extends Controller
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
     * @param  \App\ExtraPayment  $extraPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ExtraPayment $extraPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtraPayment  $extraPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraPayment $extraPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExtraPayment  $extraPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraPayment $extraPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtraPayment  $extraPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtraPayment $extraPayment)
    {
        //
    }

    public function ajax_payment_setaspaid(Request $request){
        $extra_payment = ExtraPayment::findOrFail($request->id);
        $extra_payment->status = 'Paid';
        $extra_payment->save();
        return response()->json(['result' => 'OK', 'status' => 'Paid']);
    }

    public function ajax_payment_delete(Request $request){
        $extra_payment = ExtraPayment::findOrFail($request->id);
        $extra_payment->delete();
        return response()->json(['result' => 'OK']);
    }

    public function ajax_payment_add(Request $request){
        if($request->report == ''){
            return response()->json(['result' => 'fail', 'payment' => 'id missing'])
        }else if($request->for == ''){
            return response()->json(['result' => 'fail', 'payment' => 'reason missing'])
        }else if($request->amount=<0){
            return response()->json(['result' => 'fail', 'payment' => 'amount missing'])
        }
        $payment = new ExtraPayment;
        $payment->report = $request->report;
        $payment->for = $request->for;
        $payment->amount = $request->amount;
        $payment->save();

        return response()->json(['payment'=>$payment])
    }

    public function ajax_report_save(Request $request){
        $_fullName  = explode(' ', $request->fullName);

    $firstname  = $_fullName[0];
    $surname    = $_fullName[1] .' '.$_fullName[2];

    if (!preg_match('/^[A-Za-z ]+$/', $request->fullName)) {

        return response()->json(['result' => 'Wrong full name']);
    }
    else {

        $fullName = $request->fullName;
    }

    if (!preg_match('/^[A-Za-z ]+$/', $firstname)) {

        return response()->json(['result' => 'Wrong first name, as '.$firstname]);
    }

    if (!preg_match('/^[A-Za-z ]+$/', $surname)) {

        return response()->json(['result' => 'Wrong surname']);
    }

    if (!isset($request->email) || !preg_match('/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/', $request->email)) {

        $email = '';
    }
    else {

        $email = $request->email;
    }

    if( !(preg_match("/^[0-9\-\.\+]{5,20}$/", $request->mobile))) {

        $mobile = '';
    }
    else {

        $mobile = $request->mobile;
    }


    if (!isset($request->leavingDate) || date('Y-m-d H:i:s', strtotime($request->leavingDate)) != $request->leavingDate) {

        $leavingDate = '';
    }
    else {

        $leavingDate = $request->leavingDate;
    }

    if (!isset($request->returnDate) || date('Y-m-d H:i:s', strtotime($request->returnDate)) != $request->returnDate) {

        $returnDate = '';
    }
    else {

        $returnDate = $request->returnDate;
    }

    if (!isset($request->carModel) || !preg_match('/^[A-Za-z0-9 ]+$/', $request->carModel)) {

        $carModel = '';
    }
    else {

        $carModel = $request->leavingDate;
    }

    if (!isset($request->carColour) || !preg_match('/^[A-Za-z ]+$/', $request->carColour)) {

        $carColour = '';
    }
    else {

        $carColour = $request->leavingDate;
    }

    if (!isset($request->carModel) || !preg_match('/^[A-Za-z0-9 ]+$/', $request->carModel)) {

        $carModel = '';
    }
    else {

        $carModel = $request->carModel;
    }

    if (!isset($request->carColour) || !preg_match('/^[A-Za-z0-9 ]+$/', $request->carColour)) {

        $carColour = '';
    }
    else {

        $carColour = $request->carColour;
    }

    if (!isset($request->carReg) || !preg_match('/^[A-Za-z0-9 ]+$/', $request->carReg)) {

        $carReg = '';
    }
    else {

        $carReg = $request->carReg;
    }

    if (!isset($request->returnFlightNum) || !preg_match('/^[A-Z]{2}[0-9]{1,}$/', $request->returnFlightNum)) {

        $returnFlightNum = '';
    }
    else {

        $returnFlightNum = $request->returnFlightNum;
    }

    if (!isset($request->terminal_in) || !preg_match('/^[A-Za-z0-9]{1,}$/', $request->terminal_in)) {

        $terminal_in = '';
    }
    else {
        $terminal_in = $request->terminal_in;
    }

    if (!isset($request->terminal_out) || !preg_match('/^[A-Za-z0-9]{1,}$/', $request->terminal_out)) {

        $terminal_out = '';
    }
    else {

        $terminal_out = $request->terminal_out;
    }

    //$report = $conn->query("SELECT * FROM reports r WHERE r.id = '" . $request->report) . "'");
    $report = Report::findOrFail($request->report);
    foreach ($report as $row){
        $report[] = $row;
    }

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
        $audit_trail = AuditTrail::Insert([
            'report' => $request->report,
            'record' => json_encode($auditTrailResult, JSON_PRETTY_PRINT)
        ]);
    }
        $report->fullname = $fullName;
        $report->firstname = $firstname;
        $report->surname = $surname;
        $report->email = $email;
        $report->mobile = $mobile;
        $report->status = 'Amended';
        $report->leavingDate = $leavingDate;
        $report->returnDate = $returnDate;
        $report->carModel = $carModel;
        $report->carColour = $carColour;
        $report->carReg = $carReg;
        $report->returnFlightNum = $returnFlightNum;
        $report->terminal_in = $terminal_in;
        $report->terminal_out = $terminal_out;
        $report->notes = $notes;
        $report->save();

        return response()->json(['result'=>'OK']);
    }
}
