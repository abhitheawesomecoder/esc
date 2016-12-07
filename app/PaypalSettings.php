<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class PaypalSettings extends Model {

    

    

    protected $table    = 'paypalsettings';
    
    protected $fillable = [
          'paypal_mode',
          'paypal_api_username',
          'paypal_api_password',
          'paypal_api_signature',
          'paypal_app_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        PaypalSettings::observe(new UserActionsObserver);
    }
    
    
    
    
}