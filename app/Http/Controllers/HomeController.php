<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Airport;
use App\Consolidator;
use App\Product;
use App\Helpers\HelperFunctions;
use App\Image;
use App\Alert;
use DB;
use \Carbon\Carbon;
use App\Report;
use App\Helpers\ImageResize;
use App\Helpers\ImageResizeException;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('home', compact('services', 'airports', 'consolidators'));
    }

    public function daily()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('daily', compact('services', 'airports', 'consolidators'));
    }

    public function stats()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('stats', compact('services', 'airports', 'consolidators'));
    }

    public function levels()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('levels', compact('services', 'airports', 'consolidators'));
    }
    public function monthly()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('monthly', compact('services', 'airports', 'consolidators'));
    }

    public function products()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        $products = Product::all();
        return view('products', compact('services', 'airports', 'consolidators', 'products'));
    }
    public function alerts()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        $alerts = Alert::all();
        return view('alerts', compact('services', 'airports', 'consolidators', 'alerts'));
    }

    public function logs()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        $alerts = Alert::all();
        return view('logs', compact('services', 'airports', 'consolidators', 'alerts'));
    }

    public function prices()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('prices', compact('services', 'airports', 'consolidators'));
    }

    public function daily_without_terminal()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('daily_without_terminal', compact('services', 'airports', 'consolidators'));
    }

    public function extra_payments()
    {
        $services = Service::all();
        $airports = Airport::all();
        $consolidators = Consolidator::all();
        return view('extra_payments', compact('services', 'airports', 'consolidators'));
    }

    public function ajax_search(Request $request){
        $help_func = new HelperFunctions;

        if($request->filter == 'all'){
            $reports_array = Report::with(['service','airport','consolidator'])
            ->where('id','LIKE','%'.$request->search.'%')
            ->orWhere('refNum','LIKE','%'.$request->search.'%')
            ->orWhere('firstname','LIKE','%'.$request->search.'%')
            ->orWhere('surname','LIKE','%'.$request->search.'%')
            ->orWhere('mobile','LIKE','%'.$request->search.'%')
            ->orWhere('carReg','LIKE','%'.$request->search.'%')
            ->orderBy('created','desc')
            ->take(50)->get();
        }else if($request->filter == 'carReg'){
            $reports_array = Report::with(['service','airport','consolidator'])
            ->where('id','LIKE','%'.$request->search.'%')
            ->orWhere('carReg','LIKE','%'.$request->search.'%')
            ->orderBy('created','desc')
            ->take(50)->get();
        }else if($request->filter == 'ref'){
            $reports_array = Report::with(['service','airport','consolidator'])
            ->where('id','LIKE','%'.$request->search.'%')
            ->orWhere('refNum','LIKE','%'.$request->search.'%')
            ->orderBy('created','desc')
            ->take(50)->get();
        }else if($request->filter == 'name'){
            $reports_array = Report::with(['service','airport','consolidator'])
            ->where('id','LIKE','%'.$request->search.'%')
            ->orWhere('firstname','LIKE','%'.$request->search.'%')
            ->orWhere('surname','LIKE','%'.$request->search.'%')
            ->orderBy('created','desc')
            ->take(50)->get();
        }
        

        $reports = [];
        foreach ($reports_array as $reportIndex => $reportItem) {

        // get a nice copy of ajax_report.php
            $reports[$reportIndex]['_created_relative']         = $help_func->relativeTime(strtotime($reportItem['created']));
            $reports[$reportIndex]['_created_formatted']        = date('j M h:i', strtotime($reportItem['created']));
            $reports[$reportIndex]['_lastUpdate_formatted']     = date('j M h:i', strtotime($reportItem['lastUpdate']));
            $reports[$reportIndex]['_name']                     = $reportItem['firstname'] . ' ' . $reportItem['surname'];
            $reports[$reportIndex]['_leavingDate_formatted']    = date('d/m/Y', strtotime($reportItem['leavingDate']));
            $reports[$reportIndex]['_leavingDate_additional']   = date('h:i A', strtotime($reportItem['leavingDate']));
            $reports[$reportIndex]['_returnDate_formatted']     = date('d/m/Y', strtotime($reportItem['returnDate']));
            $reports[$reportIndex]['_returnDate_additional']    = date('h:i A', strtotime($reportItem['returnDate']));

            $reports[$reportIndex]['_airport_acronym']          = $reportItem['airport']['acronym'];
            $reports[$reportIndex]['_airport_name']             = $reportItem['airport']['name'];

            $reports[$reportIndex]['_type_acronym']             = $reportItem['service']['acronym'];
            $reports[$reportIndex]['_type_name']                = $reportItem['service']['name'];

            $reports[$reportIndex]['refNum']                    = $reportItem['refNum'];
            $reports[$reportIndex]['product']                   = $reportItem['product'];

            $reports[$reportIndex]['terminal_in']               = $reportItem['terminal_in'];
            $reports[$reportIndex]['terminal_out']              = $reportItem['terminal_out'];

            $reports[$reportIndex]['surname']                   = $reportItem['surname'];
            $reports[$reportIndex]['mobile']                    = $reportItem['mobile'];

            $reports[$reportIndex]['fullName']                  = $reportItem['fullName'];
            $reports[$reportIndex]['_consolidator_name']        = $reportItem['consolidator']['name'];
            $reports[$reportIndex]['payment']                   = $reportItem['payment'];

            if(trim($reportItem['status']) == 'Ok' ||
                trim($reportItem['status']) == 'ok' ||
                trim($reportItem['status']) == 'ACTIVE' ||
                trim($reportItem['status']) == 'Active' ||
                trim($reportItem['status']) == 'NEW' ||
                trim($reportItem['status']) == 'New' ||
                trim($reportItem['status']) == 'new') {

                $status = 'Ok';
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

        $status = $reportItem['status'];
        $reports[$reportIndex]['status'] = ucfirst(trim($status));
    }

    return response()->json($reports);
}

public function image_upload(Request $request){
    if ($_FILES) {
      if (!isset($request->report) || intval($request->report) == 0 || intval($request->report) != $request->report) {
        die();
    }

    if ($_FILES['file']['error'] == 0) {
        $image_name = md5(uniqid(rand(), true));

        $imageResizer = new \Gumlet\ImageResize($_FILES['file']['tmp_name']);
        $imageResizer->resizeToBestFit(100, 100);
        $imageResizer->save('data/images/image_reports_' . $image_name .'.jpg', IMAGETYPE_JPEG, 100);

        $imageResizer = new \Gumlet\ImageResize($_FILES['file']['tmp_name']);
        $imageResizer->save('data/images/image_reports_' . $image_name .'-original.jpg', IMAGETYPE_JPEG, 100);

        $img = Image::Insert([
            'report' => $request->report,
            'name'  => $image_name,
            'size' => filesize('data/images/image_reports_' . $image_name . '.jpg')
        ]);
        return response()->json('');
    }
}
else {
    $image_name = md5(uniqid(rand(), true));

    if (!isset($_GET['report']) || intval($_GET['report']) == 0 || intval($_GET['report']) != $_GET['report']) {
        die();
    }
    $img = Image::Insert([
        'report' => $request->report,
        'name'  => $image_name,
        'size' => filesize('data/images/image_reports_' . $image_name . '.jpg')
    ]);
    return response()->json($img); 
}
}

public function image_delete(Request $request){

}


public function ajax_stats(Request $request){

  $dateFrom = date('Y-m-d');
  if (isset($_POST['date_from']) && date('Y-m-d', strtotime($_POST['date_from'])) ==  $_POST['date_from']) {
      $dateFrom = $_POST['date_from'];
  }

  $dateTo = date('Y-m-d');
  if (isset($_POST['date_to']) && date('Y-m-d', strtotime($_POST['date_to'])) ==  $_POST['date_to']) {
      $dateTo = $_POST['date_to'];
  }

  $data = array();

  $consolidators = Consolidator::all();
  foreach ($consolidators as $consolidator) {
      $data[$consolidator->id] = array(
        'acronym' => $consolidator->acronym,
        'data' => array()
    );

      $date = $dateFrom;

      $count = 0;

      while ($date <= $dateTo && $count < 14) {
        $reports = Report::select(['consolidatorID',DB::raw('COUNT(id) as total_id')])
        ->whereDate('leavingDate',$date)  
        ;
        if($request->service) $reports = $reports->where('typeID',$request->service);
        if($request->airport) $reports = $reports->where('airportID',$request->airport);
        $reports = $reports->groupBy('consolidatorID')->get();

        foreach ($data as $dataKey => $dataItem) {
            $data[$dataKey]['data'][date('jS M', strtotime($date))] = 0;
        }

        foreach ($reports as $resultKey => $resultItem) {
            $data[$resultItem->consolidatorID]['data'][date('jS M', strtotime($date))] = $resultItem->total_id;
        }

        $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));

        $count++;
    }

}
return response()->json($data);
}


public function ajax_levels(Request $request){

    $selectedDate = date('Y-m-d');
    if (isset($_POST['date']) && date('Y-m-d', strtotime($_POST['date'])) ==  $_POST['date']) {
        $selectedDate = $_POST['date'];
    }


    $start = 0;
    $data = array();

    for ($i = 14; $i >= 0; $i--) {

        $date = date('Y-m-d', strtotime('-' . $i . ' days', strtotime($selectedDate)));
        if ($start == 0) {
            $reports = Report::select([DB::raw('COUNT(id) as start')])->where('leavingDate','<=',Carbon::parse($date))->where('returnDate','>=',Carbon::parse($date));
            if($request->service) 
                $reports = $reports->where('typeID',$request->service);
            else
                $reports = $reports->whereIn('typeID',['1','2']);
            if($request->airport) 
                $reports = $reports->where('airportID',$request->airport);
            else
                $reports = $reports->whereIn('airportID',['1','2','3']);
            if($request->consolidator)
                $reports = $reports->where('consolidatorID',$request->consolidator);

            $start = $reports->first()->start;
        }
        $reports = Report::select([DB::raw($date.' as _date'),DB::raw('SUM(IF(DATE(leavingDate) = "'.$date.'", 1, 0)) AS _out'),DB::raw('SUM(IF(DATE(returnDate) = "'.$date.'", 1, 0)) AS _in')]);
        if($request->service) 
            $reports = $reports->where('typeID',$request->service);
        else
            $reports = $reports->whereIn('typeID',['1','2']);
        if($request->airport) 
            $reports = $reports->where('airportID',$request->airport);
        else
            $reports = $reports->whereIn('airportID',['1','2','3']);
        if($request->consolidator)
            $reports = $reports->where('consolidatorID',$request->consolidator);
        // return response()->json($reports->get());

        $reports = $reports->get();

        foreach($reports as $row){

            $tmp[0]['_date_formatted'] = date('jS M', strtotime($date));
            $tmp[0]['_start'] = $start;

            if (!isset($tmp[0]['_out'])) {
                $tmp[0]['_out'] = "1";
            }
            else {
                $tmp[0]['_out'] = $row->_out;
            }

            if (!isset($tmp[0]['_in'])) {
                $tmp[0]['_in'] = "2";
            }
            else {
                $tmp[0]['_in'] = $row->_in;
            }

            $data[] = $tmp[0];

            $start = $start - $tmp[0]['_out'] + $tmp[0]['_in'];
        }

    }
    return response()->json($data);
}

public function ajax_monthly(Request $request){
    if($request->date_year && $request->date_month){
        $date = $request->date_year .'-'. $request->date_month;
    }else if($request->date_year){
        $date = $request->date_year .'-'.date('m');
    }else if($request->date_month){
        $date = date('Y') .'-'. $request->date_month;
    }else{
        $date = date('Y-m');
    }

    $count_out = Report::where('leavingDate', 'like', '%'.$date.'%')->count();
    $count_in = Report::where('returnDate', 'like', '%'.$date.'%')->count();

    if($request->service && $request->airport){
        $count_out = Report::where('leavingDate', 'like', '%'.$date.'%')->where('typeID',$request->service)->where('airportID',$request->airport)->count();

        $count_in = Report::where('returnDate', 'like', '%'.$date.'%')->where('typeID',$request->service)->where('airportID',$request->airport)->count();
    }else if($request->service) {
        $count_out = Report::where('leavingDate', 'like', '%'.$date.'%')->where('typeID',$request->service)->count();
        $count_in = Report::where('returnDate', 'like', '%'.$date.'%')->where('typeID',$request->service)->count();
    }else if($request->airport) {
        $count_out = Report::where('leavingDate', 'like', '%'.$date.'%')->where('airportID',$request->airport)->count();
        $count_in = Report::where('returnDate', 'like', '%'.$date.'%')->where('airportID',$request->airport)->count();
    } 

    // return response()->json($reports->toArray());

    $data = array(
      'total' => array(
        'out' => $count_out,
        'in' => $count_in
    ),
      'reports' => array(),
      'totals' => array(
        'bookings' => 0,
        'per_booking' => 0,
        'estimate_net' => 0
    )
  );

    // $tmp1 = Report::whereRaw(DB::raw('SUBSTRING(leavingDate, 1, 7) = '.$date))->groupBy('consolidatorID',)
    $tmp1 = DB::table(DB::raw('reports as r'))
    ->select(DB::raw("r.consolidatorID, c.name AS _agent, CONCAT(a.acronym, ' ', r.product) AS _product, COUNT(r.id) AS _bookings, TRUNCATE(SUM(r.net)/COUNT(r.id), 2) AS _per_booking, 'N/A' AS _accuracy, TRUNCATE(SUM(r.net), 2) AS _estimate_net"))
    ->where('leavingDate', 'like', '%'.$date.'%')->orWhere('returnDate', 'like', '%'.$date.'%')
    ->leftJoin(DB::raw('airports AS a'),'a.id', '=', 'r.airportID')
    ->leftJoin(DB::raw('consolidators AS c'), 'c.id', '=','r.consolidatorID');
    if($request->service) $tmp1 = $tmp1->where('typeID',$request->service);
    if($request->airport) $tmp1 = $tmp1->where('airportID',$request->airport);
    $tmp1 = $tmp1->groupBy(['r.consolidatorID', '_product'])->get()->toArray();

    foreach ($tmp1 as $report) {
        $report = (array) $report;
        $data['totals']['bookings'] += intval($report['_bookings']);
        $data['totals']['per_booking'] = (floatval($data['totals']['estimate_net']) + floatval($report['_estimate_net']))/intval($data['totals']['bookings']);
        $data['totals']['estimate_net'] = floatval($data['totals']['estimate_net']) + floatval($report['_estimate_net']);

        if (!isset($data['reports'][$report['consolidatorID']])) {
            $data['reports'][$report['consolidatorID']] = array(
              'head' => array(
                '_agent' => $report['_agent'],
                '_product' => '-',
                '_bookings' => intval($report['_bookings']),
                '_per_booking' => floatval($report['_per_booking']),
                '_accuracy' => 'N/A',
                '_estimate_net' => floatval($report['_estimate_net'])
            ),
              'rows' => array(
                $report
            )
          );
        } else {
            $data['reports'][$report['consolidatorID']]['head']['_bookings'] += intval($report['_bookings']);
            $data['reports'][$report['consolidatorID']]['head']['_per_booking'] = (floatval($data['reports'][$report['consolidatorID']]['head']['_estimate_net']) + floatval($report['_estimate_net']))/intval($data['reports'][$report['consolidatorID']]['head']['_bookings']);
            $data['reports'][$report['consolidatorID']]['head']['_accuracy'] = 'N/A';
            $data['reports'][$report['consolidatorID']]['head']['_estimate_net'] = floatval($data['reports'][$report['consolidatorID']]['head']['_estimate_net']) + floatval($report['_estimate_net']);

            $data['reports'][$report['consolidatorID']]['rows'][] = $report;
        }
    }
    return response()->json($data);
}
public function ajax_extra_payments(Request $request){
      $result = DB::table(DB::raw('extra_payments as ep'))
      ->select(DB::raw("ep.*, DATE_FORMAT(ep.created_at, '%a %D %b %Y %H:%i') AS _formated_date, CONCAT_WS('', r.firstname, r.surname) AS totname, r.refNum AS _refNum"))
      ->leftJoin(DB::raw('reports AS r'),'r.id', '=', 'ep.report_id');
      if($request->service) $result = $result->where('typeID',$request->service);
      if($request->airport) $result = $result->where('airportID',$request->airport);
      $result = $result->orderBy('created_at','desc')->take(50)->get()->toArray();
      return response()->json($result);
  }

  public function ajax_log(Request $request){
    $logs = DB::table(DB::raw('audit_trail AS at'))
    ->select(DB::raw('at.*, r.refNum AS _refNum'))
    ->leftJoin(DB::raw('reports AS r'),'r.id','=','at.report_id')
    ->orderBy('created_at','desc')->take(50)->get()->toArray();      

    if(sizeof($logs) == 0)  {
      return response()->json(['no items']);
    }else{
        $log = array();
        foreach($logs as $row) {
            $row = (array) $row;
            $log[$row['id']]                       = $row;
            $log[$row['id']]['_date_formatted']    = date('j M h:i', strtotime($row['created_at']));
            $log[$row['id']]['_refNum']            = $row['_refNum'];
            $log[$row['id']]['_record']            = json_decode($row['record']);
        }
    }
    
    return response()->json($log);
    }

    public function admin_price_get_product(Request $request){
        try{
            $product = Product::findOrFail($request->pid);
            $reports = '{
            "buffer": "",
            "errors": "",
            "toasts": [],
            "result": {';
            $reports .= $product->prices_array;

            $reports .= '"grid": [';
                $reports .= $product->prices_grid_A.',';
                $reports .= $product->prices_grid_B.',';
                $reports .= $product->prices_grid_C.',';
                $reports .= $product->prices_grid_D.',';
                $reports .= $product->prices_grid_E.',';
                $reports .= $product->prices_grid_F.' ';
            $reports .= ' ] ';
            $reports .= ' } }';
            return response($reports);
        }catch(\Exception $e){
            return response("not set ".$request->pid);
        }
    }
    public function admin_price_get_promo(Request $request){
        try{
            $product = Product::findOrFail($request->product_id);
            $reports = '{
            "buffer": "",
            "errors": "",
            "toasts": [],
            "result": ';
            $reports .= $product->prices_array;
            $reports .= ' }';
            return response($reports);
        }catch(\Exception $e){
            return response("not set ".$request->product_id);
        }
    }
    public function admin_price_set_bands(Request $request){
        if(!$request->band || $request->band == ''){
            return response('no band');
        }
        $bands = '"bands": ';
        $bands .= $request->band;
        $bands .= ', ';
        $product = Product::findOrFail($request->product_id);
        $product->prices_array = $bands;
        $product->save();
        return response(true);
    }
    public function admin_price_set_grid(Request $request){
        $prices_grid = "prices_grid_".$request->band;
        $product = Product::findOrFail($request->product_id);
        $product->{$prices_grid} = $request->band;
        $product->save();
        return response(true);

    }
}

