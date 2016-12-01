<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class WithdrawalRequest extends Model {

    

    

    protected $table    = 'withdrawalrequest';
    
    protected $fillable = [
          'gateway_name',
          'user_id',
          'amount',
          'status'
    ];
    

    public static function boot()
    {
        parent::boot();

        WithdrawalRequest::observe(new UserActionsObserver);
    }
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    
    
    
}