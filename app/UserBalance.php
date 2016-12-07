<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class UserBalance extends Model {

    

    

    protected $table    = 'userbalance';
    
    protected $fillable = [
          'user_id',
          'main_balance',
          'escrow_balance'
    ];
    

    public static function boot()
    {
        parent::boot();

        UserBalance::observe(new UserActionsObserver);
    }
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    
    
    
}