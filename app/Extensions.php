<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;




class Extensions extends Model {

    

    

    protected $table    = 'extensions';
    
    protected $fillable = [
          'name',
          'url',
          'status',
          'type'
    ];
    

    public static function boot()
    {
        parent::boot();

        Extensions::observe(new UserActionsObserver);
    }
    
    
    
    
}