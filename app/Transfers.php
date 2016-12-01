<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class Transfers extends Model {

    

    

    protected $table    = 'transfers';
    
    protected $fillable = [
          'user_id',
          'receiverid',
          'amount',
          'status',
          'description'
    ];
    

    public static function boot()
    {
        parent::boot();

        Transfers::observe(new UserActionsObserver);
    }
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    
    
    
}