<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class Transactions extends Model {

    

    

    protected $table    = 'transactions';
    
    protected $fillable = [
          'gateway_name',
          'user_id',
          'amount',
          'transation_id',
          'status',
          'type'
    ];
    

    public static function boot()
    {
        parent::boot();

        Transactions::observe(new UserActionsObserver);
    }
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    
    
    
}