<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class Temp extends Model {

    

    

    protected $table    = 'temp';
    
    protected $fillable = [
          'table_name',
          'record_id',
          'key',
          'value'
    ];
    

    public static function boot()
    {
        parent::boot();

        Temp::observe(new UserActionsObserver);
    }
    
    
    
    
}