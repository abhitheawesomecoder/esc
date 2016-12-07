<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class EscrowSettings extends Model {

    

    

    protected $table    = 'escrowsettings';
    
    protected $fillable = [
          'currency_code',
          'welcome_message',
          'escrow_commission'
    ];
    

    public static function boot()
    {
        parent::boot();

        EscrowSettings::observe(new UserActionsObserver);
    }
    
    
    
    
}