<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public function airport(){
    return $this->belongsTo('App\Airport');
  }

  public function service(){
    return $this->belongsTo('App\Service');
  }
}
