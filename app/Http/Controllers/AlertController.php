<?php

namespace App\Http\Controllers;

use App\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
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
         if ($request->id && $request->id > 0) {
            Alert::findOrFail($request->id)->get();
        }
        else if ($request->carReg && $request->email) {

            if (!preg_match('/^[A-Za-z0-9 ]+$/', $request->carReg)) {
                die();
            }
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                die();
            }

            # check if plate exist;
            $check = Alert::where('carReg',$request->carReg)->get();
            if($check->count() > 0) {
                # do nothing since would produce a duplicate
            }
            else {
               
                $alert = new Alert;
                $alert->carReg = $request->carReg;
                $alert->email = $request->email;
                $alert->save();
            }

        }
        return redirect()->route('alerts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        //
    }
}
