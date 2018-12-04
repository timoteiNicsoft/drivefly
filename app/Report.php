<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function airport(){
      return $this->belongsTo('App\Airport','airportID');
    }

    public function service(){
      return $this->belongsTo('App\Service','typeID');
    }

    public function consolidator(){
      return $this->belongsTo('App\Consolidator','consolidatorID');
    }

    public function extra_payments(){
      return $this->hasMany('App\ExtraPayment','id','report');
    }
}
